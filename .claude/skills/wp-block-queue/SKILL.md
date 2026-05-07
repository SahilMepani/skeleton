---
name: wp-block-queue
description: Processes the next pending block in .claude/wp-block-queue.md by invoking /wp-block with that entry's URLs and notes, writes back a result, updates a usage forecast, and schedules the next tick based on 5h rate-limit headroom. Triggered explicitly via /wp-block-queue (typically wrapped in /loop).
metadata:
    mcp-server: figma, figma-desktop, playwright
---

# wp-block-queue — one tick = one block

## How the user runs this

```
/loop /wp-block-queue
```

That's the canonical entry point. `/loop` puts us in dynamic-pacing mode so this skill can self-schedule via `ScheduleWakeup`. Running `/wp-block-queue` bare also works (it just won't auto-resume after a paused tick).

## Files this skill owns

- `.claude/wp-block-queue.md` — the queue. User-edited; this skill rewrites status markers, the `result:` block per entry, and the top-of-file `<!-- forecast: ... -->` comment.
- `.claude/.queue-stats.json` — rolling array of recent per-block costs (e.g. `[12.4, 9.1, 11.0]`). Newest at end. Cap at 5 entries.

Read but never write:
- `~/.claude/.usage.json` — populated by the statusline; contains `five_used`, `five_resets`, `seven_used`, `seven_resets`, `captured_at`.

## Queue file format

Headings under `# Block Queue`, one per block:

```markdown
## [STATUS] {slug}
- mobile: {url}
- desktop: {url}
- notes: |
    {free-form user context, optional}
- result: |
    {written by this skill, optional}
```

`STATUS` markers:
- `[ ]` pending — pick this one
- `[~]` running — should only exist transiently; if seen on entry, treat as pending and overwrite (previous tick crashed mid-write)
- `[x]` done — skip
- `[!]` failed — skip (user must clear manually after fixing)

`mobile:` / `desktop:` — single-line URLs. **Never modify these.**
`notes:` — multi-line user text under a `|` indicator. **Never modify these.** Forward verbatim into `/wp-block`.
`result:` — multi-line, this skill writes it. Overwrite if re-running a `[!]` entry the user has reset to `[ ]`.

## Step 1 — Snapshot usage and pick an entry

1. `cat ~/.claude/.usage.json` → parse `five_used_before` (float, 0–100) and `five_resets` (epoch seconds). If file missing or unreadable, set `five_used_before = 0` and proceed (don't bail — the statusline may not have run yet on first session start).
2. Read `.claude/wp-block-queue.md`. Find the first heading matching `^## \[[ ~]\] (.+)$`. If none → **queue empty path**:
    - Update the forecast comment one last time (use current `five_used_before`, leave est_room blank).
    - Count totals (`[x]` and `[!]`).
    - Fire `PushNotification` with message like `wp-block-queue done — N built, M failed`.
    - Print one-line summary. Exit. Do NOT call ScheduleWakeup.

## Step 2 — Mark the entry running and parse it

1. Flip the entry's marker to `[~]`. Save the file.
2. Extract:
    - `slug` = the H2 text after the marker.
    - `mobile_url`, `desktop_url` = the single-line values.
    - `notes` = the YAML-ish block-scalar under `notes: |` (preserve newlines; trim trailing blank lines).
3. Validate both URLs match `figma.com/design/.+node-id=`. If either fails → **failure path** (Step 7).

## Step 3 — Auto-register the slug

1. Read `blocks/config.php`. Find the `$block_types = array(` block.
2. Convert `slug` to Title Case (`portfolio-showcase` → `Portfolio Showcase`). If that exact string is already in the array, skip. Otherwise append a new `'<Title Case>',` line before the closing `);`. Preserve tab indentation.
3. Remember whether you appended (used in the `result:` write).

## Step 4 — Invoke /wp-block

Call the `wp-block` skill via the `Skill` tool:

```
Skill(skill="wp-block", args="""
mobile: {mobile_url}
desktop: {desktop_url}

User notes for this block (forwarded from queue):
{notes if notes else "(none)"}
""")
```

The wp-block skill reads inputs from the args and runs end-to-end (writes `.json/.scss/.php/.js` under `blocks/{slug}/`).

While it runs, watch for and remember any of these for the `result:` write-back:

- design-vs-codebase mismatches the wp-block skill called out (e.g. custom font weights not in tokens, missing CSS variables)
- Swiper wiring decisions ("mobile slider + desktop grid → destroy-above-md")
- ambiguity questions the wp-block skill normally asks but had to resolve unilaterally because it's running unattended
- Figma fetch fallbacks (truncation → metadata)
- anything the wp-block skill flagged as "confirm before shipping"

If `/wp-block` errors or returns failure → **failure path** (Step 7).

## Step 5 — Snapshot usage after, compute cost

1. Re-read `~/.claude/.usage.json` → `five_used_after`. If file unchanged (statusline didn't refresh yet), wait briefly then re-read once. If still stale, fall back to `five_used_after = five_used_before` (cost will be 0; not great but not fatal).
2. `cost = max(0, five_used_after - five_used_before)`.
3. Append `cost` to `.claude/.queue-stats.json`, trim to last 5 entries. Compute `avg_cost = mean(stats) or 10` (10% as a safe initial guess).

## Step 6 — Write back result, mark done, update forecast

1. Build the `result:` body. Multi-line, indented under `result: |`. Include only items that are true:
    - `Auto-registered '{Title Case}' in blocks/config.php.` (if appended)
    - `Swiper: {description}.` (if a slider was wired)
    - `HEADS-UP: {issue}.` for each design/codebase mismatch
    - `Cost: ~{cost}% of 5h window.` (always)
2. Replace any existing `result: |` block under that entry with the new one (or insert it after `notes:` / after `desktop:` if no notes). Don't touch `mobile:`, `desktop:`, or `notes:`.
3. Flip the entry's marker `[~]` → `[x]`.
4. Compute `est_room = floor((100 - five_used_after) / max(avg_cost, 1))`.
5. Rewrite the top-of-file forecast comment:
    ```
    <!-- forecast: managed by /wp-block-queue, do not edit -->
    <!-- 5h used: {five_used_after:.0f}% | avg/block: {avg_cost:.1f}% | est room this window: {est_room} blocks | last updated: {YYYY-MM-DD HH:MM} -->
    ```
    If both comment lines don't already exist at the top, insert them above the `# Block Queue` heading.
6. Save the queue file.

## Step 7 — Failure path

(Triggered when validation fails in Step 2 or `/wp-block` errors in Step 4.)

1. Build a one-line `result: failed — {short reason}`.
2. Write it under the entry, flip marker `[~]` → `[!]`.
3. Fire `PushNotification`: `wp-block-queue stalled on {slug}: {short reason}` (under 200 chars).
4. Continue to Step 8 — one bad block doesn't kill the loop.

## Step 8 — Schedule the next tick

Re-read `five_used_after` from `.usage.json` (or use the value from Step 5). Count remaining `[ ]` entries.

Decision tree:

| condition | action |
| --- | --- |
| no `[ ]` entries left | no wakeup; print "queue drained" line |
| `five_used_after < 80` | `ScheduleWakeup(delaySeconds=120, prompt="/loop /wp-block-queue", reason="processing next block in queue")` |
| `five_used_after >= 80` AND `(five_resets - now) > 3600` | `ScheduleWakeup(delaySeconds=3600, prompt="/loop /wp-block-queue", reason="paused — 5h cap reached, will re-check")` then `PushNotification("wp-block-queue paused — 5h cap reached, resuming after reset at HH:MM, N items left")` |
| `five_used_after >= 80` AND `(five_resets - now) <= 3600` | `delay = max(120, int(five_resets - now) + 120)` then `ScheduleWakeup(delaySeconds=delay, prompt="/loop /wp-block-queue", reason="resuming shortly after 5h reset")` then `PushNotification("wp-block-queue paused — resuming after 5h reset at HH:MM, N items left")` |

`delaySeconds` is clamped to [60, 3600] by the runtime; chains naturally for waits longer than 1h.

Only fire the "paused" PushNotification once per pause window — if the previous tick already paused (you can detect by reading the most recent `result:` cost — but simpler: just always fire; mobile dedupes). Do NOT push for normal `<80%` rolls.

## Step 9 — Report

One terse line to stdout:
```
done: {slug} | cost {cost:.0f}% | 5h used {five_used_after:.0f}% | next: {wakeup_summary}
```

Where `wakeup_summary` is `120s`, `~Hh{M}m to reset`, or `queue drained`.

## Hard rules

- Never modify `mobile:`, `desktop:`, or `notes:` content.
- Never delete a `[!]` entry — leave it for the user to inspect.
- Always flip `[~]` to a terminal status (`[x]` or `[!]`) before exiting; never leave a tick in `[~]`.
- Failure of one entry must not abort the loop — schedule the next tick.
- Process exactly one block per invocation.
- Never call `git commit` or push from this skill — the user reviews and commits manually.
