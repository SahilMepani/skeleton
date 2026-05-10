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
- `.claude/.wp-queue-stats.json` — rolling array of recent per-block costs (e.g. `[12.4, 9.1, 11.0]`). Newest at end. Cap at 5 entries. **Migration:** if a legacy `.claude/.queue-stats.json` exists from before the rename, read it once, write the contents to `.wp-queue-stats.json`, then delete the legacy file. Don't merge — the legacy file is the only source of truth in that case.
- `.claude/.wp-queue-pause-state.json` — single epoch-second integer recording when the most recent "paused" PushNotification fired. Used in Step 8 to dedupe pause pushes inside a 5h window.

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
- `[?]` parked — user-set; skip without counting as failure (e.g. blocked on a missing asset or design question). Treat identically to `[x]` for selection; counted separately in the empty-queue summary.

`mobile:` / `desktop:` — single-line URLs. **Never modify these.**
`notes:` — multi-line user text under a `|` indicator. **Never modify these.** Forward verbatim into `/wp-block`.
`result:` — multi-line, this skill writes it. Overwrite if re-running a `[!]` entry the user has reset to `[ ]`.

## Step 1 — Snapshot usage and pick an entry

1. `cat ~/.claude/.usage.json` → parse `five_used_before` (float, 0–100), `five_resets` (epoch seconds), and `captured_at` (epoch seconds). If file missing or unreadable, set `five_used_before = 0`, `usage_stale = true`, and proceed (don't bail — the statusline may not have run yet on first session start). If `captured_at` is older than 300 s relative to `now`, also set `usage_stale = true`. A stale snapshot doesn't block the tick, but it suppresses cost-stat updates in Step 5 so a single bad reading doesn't poison the rolling average.
2. Read `.claude/wp-block-queue.md`. Find the first heading matching `^## \[[ ~]\] (.+)$` (parked `[?]`, done `[x]`, and failed `[!]` are all skipped). If none → **queue empty path**:
    - Update the forecast comment one last time (use current `five_used_before`; render `est room this window: —` when there's no usable forecast).
    - Count totals separately: `built` (`[x]`), `failed` (`[!]`), `parked` (`[?]`).
    - Fire `PushNotification` with message like `wp-block-queue done — N built, M failed, K parked` (omit the `parked` segment when K = 0).
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
2. Convert `slug` to Title Case (`portfolio-showcase` → `Portfolio Showcase`). The Title-Case form is best-effort — numeric tokens (`our-2024-launch`) and acronyms (`usa-flag`) won't always match an established repo convention, so step 3 below uses a lenient comparison.
3. Compare case-insensitively against every existing string entry in the array. If any entry matches the Title-Case form, the kebab-case slug, or any token-equal variant after stripping spaces and dashes — skip registration. Otherwise append a new `'<Title Case>',` line before the closing `);`. Preserve tab indentation.
4. Remember whether you appended (used in the `result:` write **and** in Step 7's failure rollback).

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
2. Run it end-to-end: writes `.json/.scss/.php/.js` under `blocks/{slug}/`. The orchestrator has
   already auto-registered the slug in `blocks/config.php` — do NOT touch that file.
   Resolve any ambiguity unilaterally (you're running unattended) and surface the call in HEADS_UP.
3. Do NOT touch `.claude/wp-block-queue.md`, `.claude/.wp-queue-stats.json`,
   `.claude/.wp-queue-pause-state.json`, and do NOT call ScheduleWakeup or PushNotification —
   those are owned by the orchestrator.
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

If the return is unparseable (agent returned prose instead of the structured format), treat the tick as a failure and route through Step 7. The build may have completed fine, but a silent `[x]` would let a real failure slip past the user — `[!]` plus a fail reason like `subagent returned unstructured output — inspect {slug} files and re-mark as [ ] if the build is actually good` is the safer default. Failure-path ticks skip Step 5 (cost accounting) just like other failures, since their token spend isn't representative of a real block-build cost and would skew the rolling average.

## Step 5 — Snapshot usage after, compute cost

1. Re-read `~/.claude/.usage.json` → `five_used_after`, `ctx_remaining_after`, and `captured_at_after`. If `captured_at_after == captured_at` from Step 1 (statusline didn't refresh yet), wait briefly then re-read once. If still unchanged, or if `captured_at_after` is older than 300 s relative to `now`, set `usage_stale = true` and `cost = None`. Otherwise `cost = max(0, five_used_after - five_used_before)`. If `ctx_remaining` key is missing entirely (older statusline cache), set `ctx_remaining_after = 100` so the ctx gate in Step 8 is skipped rather than misfiring.
2. **Outlier guard:** if `cost > 30`, treat it as an outlier (likely picked up `/compact` overhead, an unrelated long-running task, or a clock skew) and set `cost_excluded_from_stats = true`. The number still appears in the `result:` block for transparency, but it doesn't enter the rolling average.
3. Append `cost` to `.claude/.wp-queue-stats.json` only when `usage_stale` is false **and** `cost_excluded_from_stats` is false. Trim to last 5 entries. Compute `avg_cost = mean(stats) or 10` (10% as a safe initial guess). The forecast comment update in Step 6 always runs — it just uses the previous `avg_cost` when this tick contributed nothing.

## Step 6 — Write back result, mark done, update forecast

1. Build the `result:` body. Multi-line, indented under `result: |`. Include only items that are true:
    - `Auto-registered '{Title Case}' in blocks/config.php.` (if appended)
    - `Swiper: {description}.` (if a slider was wired)
    - `HEADS-UP: {issue}.` for each design/codebase mismatch
    - Cost line (always — render whichever applies):
        - `Cost: ~{cost}% of 5h window.` — normal case
        - `Cost: ~{cost}% of 5h window (outlier — excluded from rolling average).` — when `cost_excluded_from_stats` is true
        - `Cost: unknown (statusline stale).` — when `usage_stale` is true
2. Replace any existing `result: |` block under that entry with the new one (or insert it after `notes:` / after `desktop:` if no notes). Don't touch `mobile:`, `desktop:`, or `notes:`.
3. Flip the entry's marker `[~]` → `[x]`.
4. Compute `est_room = floor((100 - five_used_after) / max(avg_cost, 1))` when usage is fresh; otherwise carry the previous forecast's `est_room` forward unchanged.
5. Rewrite the top-of-file forecast comment:
    ```
    <!-- forecast: managed by /wp-block-queue, do not edit -->
    <!-- 5h used: {five_used_after:.0f}% | avg/block: {avg_cost:.1f}% | est room this window: {est_room} blocks | last updated: {YYYY-MM-DD HH:MM} -->
    ```
    Render `est room this window: —` when the value is unavailable (queue empty path, or no usable forecast). If both comment lines don't already exist at the top, insert them above the `# Block Queue` heading.
6. Save the queue file.

## Step 7 — Failure path

(Triggered when validation fails in Step 2, `/wp-block` errors in Step 4, or the subagent returns unparseable output.)

1. **Roll back Step 3 if it appended.** If the orchestrator added a new `'<Title Case>',` line to `blocks/config.php` this tick, remove that exact line now. A `[!]` entry with a phantom registration is worse than no registration at all — the user would have to remember to clean up two places when they reset to `[ ]`. Skip the rollback when Step 3 reported "already present" (no append happened).
2. Build a one-line `result: failed — {short reason}` (or a short multi-line block if Step 5/6 added a HEADS-UP about unparseable output — keep the `failed —` prefix on the first line).
3. Write it under the entry, flip marker `[~]` → `[!]`.
4. Fire `PushNotification`: `wp-block-queue stalled on {slug}: {short reason}` (under 200 chars).
5. Continue to Step 8 — one bad block doesn't kill the loop.

## Step 8 — Schedule the next tick

Re-read `five_used_after` and `ctx_remaining_after` from `.usage.json` (or use the values from Step 5). Count remaining `[ ]` entries.

**Bare-mode guard.** `ScheduleWakeup` is only available when this skill is running under `/loop` (dynamic-pacing mode). If the call errors with "scheduling unavailable" or anything equivalent, the user ran `/wp-block-queue` bare. Don't retry — print `next-tick: not scheduled (re-run /loop /wp-block-queue to continue)` in the Step 9 report and exit cleanly. Do the same when you'd otherwise schedule but a `PushNotification` is the only useful signal (e.g. drained queue).

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

**Pause-notification dedupe.** Only fire the "paused" PushNotification once per pause window:

1. Before pushing, read `.claude/.wp-queue-pause-state.json` (single epoch-second integer) if it exists.
2. If that timestamp is within the current 5h window — i.e. `> (five_resets - 18000)` — a prior tick has already notified for this pause; skip the PushNotification but still ScheduleWakeup as normal.
3. Otherwise fire the PushNotification, then write `now` (epoch seconds) to `.claude/.wp-queue-pause-state.json`.
4. When `five_used_after < 80` (i.e. we're back in the normal continuation row), delete `.claude/.wp-queue-pause-state.json` if it exists, so the next pause window starts clean.

Do NOT push for normal `<80%` rolls.

About the `Tier A` ctx threshold (`< 40`): this was sized for an earlier model. The subagent isolation here keeps the orchestrator's context small, so 40 may be conservative on Opus 4.7. If you find the gate firing rarely (or never) over a long run, consider lowering it; if it fires multiple times per session, raise it. Don't tune it speculatively — wait for evidence in real ticks.

## Step 9 — Report

One terse line to stdout:

```
done: {slug} | cost {cost_text} | 5h used {five_used_after:.0f}% | next: {wakeup_summary}
```

`cost_text` is `{cost:.0f}%`, `{cost:.0f}% (outlier)`, or `unknown`.

`wakeup_summary` is one of:
- `120s` — normal continuation
- `~Hh{M}m to reset` — paused at 5h cap
- `compacting (manual resume)` — Tier A ctx gate fired
- `queue drained` — no remaining `[ ]` entries
- `not scheduled (bare mode)` — ScheduleWakeup unavailable; user ran without `/loop`

When `est_room == 0` and there are still `[ ]` entries, append a second line:

```
heads-up: forecast says no blocks fit in the remaining 5h window — next tick is likely to pause.
```

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
