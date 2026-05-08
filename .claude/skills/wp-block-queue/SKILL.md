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

- `~/.claude/.usage.json` — populated by the statusline; contains `five_used`, `five_resets`, `seven_used`, `seven_resets`, `ctx_remaining`, `captured_at`.

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

## Step 4 — Spawn a subagent to run /wp-block

Building the block runs **inside a foreground general-purpose subagent**, not in this orchestrator's main thread. The subagent's context absorbs the Figma fetches and file edits; the orchestrator only sees a short structured summary back. This keeps main-thread context small enough that Tier A (Step 8) rarely fires.

Call the `Agent` tool (no `run_in_background` — sequential by default; main thread blocks until the agent returns):

```
Agent(
    subagent_type="general-purpose",
    description="Build wp block {slug}",
    prompt="""
You are a one-shot block builder running inside the wp-block-queue skill.
The main thread is the orchestrator; you do the heavy work so its context stays small.

Inputs:
- mobile: {mobile_url}
- desktop: {desktop_url}
- notes (forward verbatim into the skill):
{notes if notes else "(none)"}

Instructions:
1. Invoke the `wp-block` skill via the Skill tool with these exact args:

       mobile: {mobile_url}
       desktop: {desktop_url}

       User notes for this block (forwarded from queue):
       {notes if notes else "(none)"}

   If the Skill tool is unavailable in your context, read `.claude/skills/wp-block/SKILL.md`
   and follow it step by step — the SKILL.md is the source of truth either way.
2. Run it end-to-end: writes `.json/.scss/.php/.js` under `blocks/{slug}/`. The orchestrator has
   already auto-registered the slug in `blocks/config.php` — do NOT touch that file.
   Resolve any ambiguity unilaterally (you're running unattended) and surface the call in HEADS_UP.
3. Do NOT touch `.claude/wp-block-queue.md`, `.claude/.queue-stats.json`, and do NOT call
   ScheduleWakeup or PushNotification — those are owned by the orchestrator.
4. When the build is done (or has failed), return a SHORT structured summary in this EXACT format,
   no prose preamble or closing remarks — the orchestrator parses it mechanically:

   STATUS: ok            # or `failed`
   SLUG: {slug}
   SWIPER: {one-line description, or `none`}
   HEADS_UP:
   - {single-line issue}
   - {single-line issue}
   FAIL_REASON: {one line, only when STATUS: failed}

   Use `HEADS_UP:` followed by `- (none)` if there are no issues. Keep each HEADS_UP bullet to one line.
"""
)
```

When the agent returns, parse its summary into these fields for the Step 6 `result:` write-back:

- `STATUS` — `ok` continues to Step 5; `failed` jumps to Step 7 (failure path).
- `SWIPER` — drives the `Swiper: {description}.` line (omit when `none`).
- `HEADS_UP` bullets — each becomes a `HEADS-UP: {issue}.` line. Skip when the only bullet is `(none)`.
- `FAIL_REASON` — only used in Step 7.

(The `Auto-registered '{Title Case}' in blocks/config.php.` line is driven by Step 3's own bookkeeping, not by the agent's summary.)

If the return is unparseable (agent returned prose instead of the structured format), still proceed with Step 5 cost accounting and Step 6 write-back, but add a `HEADS-UP: subagent returned unstructured output — review {slug} manually.` line so it's visible in the queue file.

## Step 5 — Snapshot usage after, compute cost

1. Re-read `~/.claude/.usage.json` → `five_used_after` and `ctx_remaining_after`. If file unchanged (statusline didn't refresh yet), wait briefly then re-read once. If still stale, fall back to `five_used_after = five_used_before` (cost will be 0; not great but not fatal). If `ctx_remaining` key is missing entirely (older statusline cache), set `ctx_remaining_after = 100` so the ctx gate in Step 8 is skipped rather than misfiring.
2. `cost = max(0, five_used_after - five_used_before)`.
3. Append `cost` to `.claude/.queue-stats.json`, trim to last 5 entries. Compute `avg_cost = mean(stats) or 10` (10% as a safe initial guess). Cost stats append + the forecast comment update in Step 6 happen unconditionally — they're independent of the Step 8 ctx-gate decision.

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

Re-read `five_used_after` and `ctx_remaining_after` from `.usage.json` (or use the values from Step 5). Count remaining `[ ]` entries.

Decision is **two-tier**: the ctx gate runs first and supersedes the 5h tree when it fires. Never fire both tiers in the same tick.

### Tier A — ctx gate (checked first)

| condition                                           | action                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                |
| --------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `ctx_remaining_after < 40` AND `[ ]` entries remain | `ScheduleWakeup(delaySeconds=60, prompt="/compact this is a queued block-builder loop where each block is fully independent — discard essentially all prior block-building context, conversation history, and tool results. Preserve only the queue file path (.claude/wp-block-queue.md) and the resume command (/loop /wp-block-queue). The next tick will re-read everything it needs from disk.", reason="ctx >60% used, compacting before next block")` then `PushNotification("wp-block-queue compacting — ctx at {100-ctx_remaining_after:.0f}% used, run /loop /wp-block-queue after compact finishes; N items left")`. Skip Tier B entirely. |

The compact instruction is verbose on purpose: it tells the summarizer to drop nearly everything because each queue tick is self-contained — the queue file on disk is the only state that needs to survive. Without that hint, `/compact` defaults to retaining task-relevant context, which here is wasted tokens.

**Why not `/clear` instead?** `/clear` would wipe context more thoroughly, but it (a) takes no arguments so we can't bundle a resume command, (b) starts a fresh session that almost certainly drops the `/loop` dynamic-pacing scheduler, and (c) has no documented wakeup-survival guarantee. The user can always manually `/clear` after seeing the `compacting…` notification if they want a harder wipe — the manual re-run step is the same either way. Don't change this to `/clear` automatically.

Only one wakeup is scheduled (the `/compact`). Wakeup survival across a `/compact` boundary isn't a documented guarantee, so the user manually re-runs `/loop /wp-block-queue` after compaction finishes — the PushNotification tells them to. Queue state in `.claude/wp-block-queue.md` is durable so resume is safe.

### Tier B — 5h gate (only when Tier A didn't fire)

| condition                                                 | action                                                                                                                                                                                                                                                                 |
| --------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| no `[ ]` entries left                                     | no wakeup; print "queue drained" line                                                                                                                                                                                                                                  |
| `five_used_after < 80`                                    | `ScheduleWakeup(delaySeconds=120, prompt="/loop /wp-block-queue", reason="processing next block in queue")`                                                                                                                                                            |
| `five_used_after >= 80` AND `(five_resets - now) > 3600`  | `ScheduleWakeup(delaySeconds=3600, prompt="/loop /wp-block-queue", reason="paused — 5h cap reached, will re-check")` then `PushNotification("wp-block-queue paused — 5h cap reached, resuming after reset at HH:MM, N items left")`                                    |
| `five_used_after >= 80` AND `(five_resets - now) <= 3600` | `delay = max(120, int(five_resets - now) + 120)` then `ScheduleWakeup(delaySeconds=delay, prompt="/loop /wp-block-queue", reason="resuming shortly after 5h reset")` then `PushNotification("wp-block-queue paused — resuming after 5h reset at HH:MM, N items left")` |

`delaySeconds` is clamped to [60, 3600] by the runtime; chains naturally for waits longer than 1h.

Only fire the "paused" PushNotification once per pause window — if the previous tick already paused (you can detect by reading the most recent `result:` cost — but simpler: just always fire; mobile dedupes). Do NOT push for normal `<80%` rolls.

## Step 9 — Report

One terse line to stdout:

```
done: {slug} | cost {cost:.0f}% | 5h used {five_used_after:.0f}% | next: {wakeup_summary}
```

Where `wakeup_summary` is `120s`, `~Hh{M}m to reset`, `compacting (manual resume)`, or `queue drained`.

## Hard rules

- The `/wp-block` builder always runs in a general-purpose subagent (foreground, sequential). Never invoke the wp-block skill directly in this orchestrator's main thread — that defeats the whole purpose of this two-tier setup.
- Never modify `mobile:`, `desktop:`, or `notes:` content.
- Never delete a `[!]` entry — leave it for the user to inspect.
- Always flip `[~]` to a terminal status (`[x]` or `[!]`) before exiting; never leave a tick in `[~]`.
- Failure of one entry must not abort the loop — schedule the next tick.
- Process exactly one block per invocation.
- If `ctx_remaining` key is missing from `.usage.json`, treat as 100 and skip the ctx gate.
- The ctx gate fires at most once per tick and supersedes the 5h tree — never both.
- Never call `/compact` mid-tick — only via `ScheduleWakeup` at the end of Step 8, so the current block's `result:` write is durable first.
- Never call `git commit` or push from this skill — the user reviews and commits manually.
