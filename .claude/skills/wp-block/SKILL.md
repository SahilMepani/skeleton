---
name: wp-block
description: Builds a complete ACF Gutenberg block (PHP + SCSS + JSON + JS) in one pass from either a mobile + desktop Figma pair or a free-form text description of the design. When only a text note is given, first delegates to /frontend-design to materialize a mobile + desktop reference, then builds the block off that reference. Reads both designs up front, inlines typography directly with fluid(mobile, desktop), and wires Swiper when mobile is a slider but desktop is static. Only invoke when explicitly called via /wp-block.
disable-model-invocation: true
---

# Block — One-pass design → ACF block (mobile + desktop)

Translates **two designs** (mobile + desktop) into PHP + SCSS + JSON + JS in a single pass. The two designs can come from either source:

- **Figma mode** — a mobile Figma URL + a desktop Figma URL (the original flow).
- **Note mode** — a free-form text description of the block. The skill first calls `/frontend-design` to materialize a mobile + desktop visual reference, then builds the block off that.

Seeing both designs up front lets the skill make heading-class and Swiper decisions correctly the first time — no `fluid(0, X)` placeholders, no late slider rewrites.

> General SCSS / PHP / JS / accessibility / ACF JSON rules already live in `CLAUDE.md`, `.cursor/AGENTS.md` (always loaded), and `.cursor/rules/*.mdc` (read on demand). This skill covers only what's specific to the two-design workflow.

## Prerequisites

- **Figma MCP** connected (used in Step 1 for `get_design_context` + `get_screenshot`).
- **`playwright-cli` skill** available (used in Step 9 if visual verification runs).
- Block exists at `blocks/{slug}/` and is registered in `blocks/config.php`. If not, ask the user to register it first.

## Inputs — auto-detect mode

Scan the user's message for any `figma.com/design/...` URL:

- **Figma mode** — one or more `figma.com` URLs present. Two URLs expected (mobile + desktop, typically 375px and 1440px+). Extract `fileKey` + `nodeId` from each: `figma.com/design/:fileKey/...?node-id=1-2` → `nodeId = 1:2`. If only one URL is supplied, ask for the other before doing any work. Proceed to **Step 1**.
- **Note mode** — no `figma.com` URL anywhere in the message. Treat the rest of the message as a free-form design note (tone, layout intent, slider vs. grid, colors, type feel, hero element, etc.). If the note is too thin to design from (e.g. just "make a testimonial block"), ask one targeted clarifying question first — the kind of detail a Figma frame would have fixed. Then proceed to **Step 1a**.

If both a Figma URL and a long note are present, **Figma mode wins** — `/frontend-design` is not called. The note becomes supplementary guidance for the Step 2 diff (copy hints, slider intent, etc.).

## Step 1 — Figma mode: fetch both designs (parallel)

Skip this step entirely in note mode; Step 1a produces the two designs instead.

Run four calls in parallel:

1. `get_design_context(mobileFileKey, mobileNodeId)`
2. `get_screenshot(mobileFileKey, mobileNodeId)`
3. `get_design_context(desktopFileKey, desktopNodeId)`
4. `get_screenshot(desktopFileKey, desktopNodeId)`

`get_design_context` already returns screenshot + layout + typography + colors + asset URLs; the explicit `get_screenshot` calls are insurance for higher-fidelity image data when the bundled screenshot is lossy. Fidelity over token cost.

If a response is truncated, fall back to `get_metadata` and fetch children individually for the affected design.

## Step 1a — Note mode: materialize the reference via `/frontend-design`

Skip this step entirely in Figma mode.

Invoke the `/frontend-design` skill via the Skill tool with a prompt that asks for **two** concrete artifacts: a **mobile (375px)** variant and a **desktop (1440px+)** variant of the block, with the user's note as the brief. Be explicit in the prompt:

- Both viewports are required so Step 2's diff has two designs to compare. Label them clearly.
- Output must be self-contained HTML + CSS (no framework, no external assets) so this skill can read it directly in context.
- Typography needs concrete `font-size` / `line-height` / `font-family` values **per viewport** so Step 2 can emit `fluid(mobile, desktop)`.
- Colors should be inline hex (matches Step 5's "Color values inline as hex" rule).
- If the note implies a slider on mobile, the mobile variant should make that explicit (off-canvas card, dots/arrows, horizontal strip). Otherwise produce static layouts at both viewports.

The `/frontend-design` output is **reference-only**: read it in-context, do not save it to `blocks/{slug}/`, do not commit it, do not present the HTML/CSS to the user as a deliverable. Once Step 7 is finished, the reference is dropped.

If `/frontend-design` returns something underspecified (missing per-viewport type values, ambiguous layout, only one viewport) — ask one targeted question or re-prompt the skill before continuing. Do not start writing block files off vague output.

## Step 2 — Diff the two designs (silent, internal)

Build an internal table per element. Never output it. Source the per-element data from whichever mode produced the designs — `get_design_context` payloads in Figma mode, or the `/frontend-design` HTML/CSS reference in note mode. The diff logic below is mode-agnostic.

| Element / Selector | Mobile | Desktop | Decision |
| --- | --- | --- | --- |

Decision rules:

- **VALUE** (same layout, different number) → `fluid(mobile, desktop)` directly in SCSS. If `mobile == desktop` → static `rem-calc(X)` for px, plain number for unitless. **Never emit `fluid(0, X)` placeholders.**
- **LAYOUT** (flex-direction, grid-template-columns, order, display change, flex-wrap, position, `max-inline-size` unconstrained → fixed) → mobile-first base + `@media (width >= $md)` containing **only** the differing structural properties. No font / padding / gap inside the MQ.
- **TYPOGRAPHY** → always inline `font-size: fluid(mobile, desktop); line-height: ...; font-family: ...;` in block SCSS. Never apply `.h1`–`.h6` classes; never `@include font(...)` or `@include text(...)`.
- **SLIDER** → flag for Step 3.

Default to VALUE when unsure. Goal: minimize media queries.

`fluid()` mechanics: `fluid($min, $max, $min-bp: 'md', $max-bp: 'xl')` → `clamp()`. Below `$md` → `$min`. Above `$xl` → `$max`. Project breakpoints live in the SCSS config (currently `$md = 768px`, `$xl = 1200px` — verify if porting). Don't widen the third/fourth args without an explicit reason.

Slider behavior signals on a viewport: horizontal overflow strip, dots / arrows, off-canvas card edges, slide-shaped cards spilling past the right edge.

## Step 3 — Decide Swiper wiring up front

Cross-reference both designs:

- **Mobile slider + desktop static/grid** → wire Swiper with `matchMedia` destroy-above-`$md`. Below `$md` Swiper runs; at/above `$md` it's destroyed and CSS owns the layout.
- **Mobile slider + desktop slider** → wire Swiper at all sizes, no destroy logic.
- **Both static** → no Swiper.
- **Ambiguous** (e.g. mobile cards spill off the right but it's unclear whether they paginate) → **ask the user** with a single targeted question, then proceed. Do not write code first. In note mode this applies the same way — if the `/frontend-design` reference doesn't make slider intent obvious, ask rather than guess.

If Swiper is wired (any of the first two cases), **read `references/swiper.md` before Steps 4–7** — it consolidates the JSON / SCSS / PHP / JS rules that follow from this decision. Skip the reference if no Swiper is wired.

## Step 4 — Write `{slug}.json`

- Field key prefix: `field_{slug}_{field_name}`. Sub-fields: `field_{slug}_{repeater}_{field}`.
- Structure: `accordion` (open=1, multi_expand=1) → `tab` → fields.
- **Never add Settings / Spacing / Display fields** — auto-injected at registration.
- Images: `"return_format": "id"`, `"preview_size": "w200"`.
- Links: `"return_format": "array"`.
- Repeaters: `"collapsed"` = key of first sub-field.
- **Default values from Figma:** put placeholder copy in `default_value` for any field type that supports it (text, textarea, number, email, url, range, password, select, radio, checkbox, button_group, true_false, color/date/time pickers, wysiwyg). PHP must not duplicate these — Step 6 only carries fallbacks for field types that can't take `default_value` (image, file, gallery, link, repeater, group, flexible_content, clone, post_object, page_link, relationship, taxonomy, user).
- If Step 3 wired Swiper, add `"needs_swiper": true` (read by `register-acf-blocks.php` to enqueue the Swiper asset bundle — see `references/swiper.md`).
- For complex / rare field types (group, flexible content, gallery, conditional logic, WYSIWYG, post object, relationship, textarea, number, true/false, oEmbed, select, button group), see `.cursor/rules/acf-json-format.mdc`.

## Step 5 — Write `{slug}.scss`

General SCSS rules (logical properties, `fluid()`, mobile-first MQs, no flex-for-gap on a vertical stack) are in CLAUDE.md / `.cursor/rules/scss-standards.mdc`. Block-specific:

- Import: `@use '../../src/sass/partials/abstracts-blocks' as *;` — `abstracts-blocks`, not plain `abstracts`.
- **Everything nests inside `.{slug}-section { … }`.** Zero top-level selectors. Media queries and modifiers nest too.
- **Plain child class names** (`.card`, `.image`, `.body`). No BEM (`.{slug}__card`). Modifiers keep `--` (`.tag--dark`). No `&__` / `&--` shorthand.
- **No `padding-inline` on `.{slug}-section`.**
- Apply Step 2 decisions:
  - VALUE rows → `fluid(mobile, desktop)` or static `rem-calc(X)`.
  - LAYOUT rows → mobile base + `@media (width >= $md) { ... }` for structural properties only.
  - TYPOGRAPHY rows → inline `font-size` / `line-height` / `font-family` in block SCSS. No `.h1`–`.h6` classes, no `@include font/text`.
- **Color values inline as hex** — write the Figma hex code directly. No token-mapping pass.
- **Swiper SCSS** (when wired): see `references/swiper.md` § SCSS — covers wrapper sizing, slide-width pattern, and the `min-inline-size: 0` / `overflow: visible` rationale.
- `#{…}` Sass interpolation required inside CSS `min()` / `max()`.

## Step 6 — Write `{slug}.php`

General PHP rules (tab indent, escape every output, `'skel'` text domain) are in CLAUDE.md / `.cursor/rules/php-standards.mdc`. Block-specific:

- Use the standard section wrapper from `.cursor/rules/project-patterns.mdc` §Block Template Structure: `skel_render_block_preview` early-return, `skel_should_display_block` early-return, `skel_get_block_developer_options` for spacing/display/custom-class plumbing, `<section class="{slug}-section section ...">` with `.container` as the **only** direct child.
- **PHP fallback shapes** (per the defaults policy in Step 4 — PHP only handles field types ACF cannot pre-seed via JSON `default_value`):
  - `image` → `DEFAULT_THUMBNAIL_ID`
  - `link` → `array( 'url' => '#', 'title' => '…', 'target' => '' )`
  - `repeater` / `group` / `flexible_content` → a small placeholder array shaped like the Figma design (typically 2–3 rows)
  - `gallery` / `file`, and relationship-style fields (`post_object`, `page_link`, `relationship`, `taxonomy`, `user`) → minimal placeholder shaped like Figma

  Keep Figma copy inside those PHP arrays so the block renders meaningfully on a fresh insert. For JSON-pre-seeded fields, PHP just calls `get_field()` — no `?:` / `??`.
- **Repeater normalization:** if a repeater only collects one useful value per row, normalize before rendering (e.g. `wp_list_pluck`) instead of carrying nested arrays through the loop.
- **Image output:** `wp_get_attachment_image()` with `loading => 'lazy'` and a sensible `sizes`. Custom sizes: `w480`, `w768`, `w1400`, `w1920`. Full-bleed images use `img-cover` inside `img-cover-block`. Linked images: add `img-link` to the `<a>`.
- **Heading markup:** never apply `.h1`–`.h6` classes. Use semantic tags (`<h2>`, `<h3>`, etc.) and let block SCSS own the size via inline `font-size` / `line-height` / `font-family`.
- **Swiper markup** (when wired): see `references/swiper.md` § PHP markup.
- **Animation attributes (MANDATORY):** every visible content element rendered by the block (headings, paragraphs, images, cards, buttons, list items, slides, etc.) must have **both** `data-inview` and `data-aos="fade-up"` attributes. The project's AOS system (`src/js/custom/data-inview.js` + `src/sass/partials/aos/`) requires both — `data-inview` triggers the IntersectionObserver, `data-aos="fade-up"` selects the animation. Pure structural wrappers (`.container`, `.swiper-wrapper`, `.swiper-slide` itself, decorative-only `<div>`s used purely for layout) do NOT need them. Inside `foreach`/`while` loops, add the attributes to each rendered item element (e.g. each card, each slide's content). When in doubt, add them — the system handles `prefers-reduced-motion` and is idempotent. Default to `fade-up`; only deviate (`fade`, `fade-left`, etc.) if the Figma frame has explicit motion direction notes.
  - Example: `<h2 data-inview data-aos="fade-up"><?php echo esc_html( $title ); ?></h2>`, `<article class="card" data-inview data-aos="fade-up">…</article>`.
- Guard every `foreach` with `if ( is_array( $items ) && ! empty( $items ) ) :`.

## Step 7 — Write `{slug}.js`

- Default: leave the auto-generated stub `(() => { })();`.
- Need JS for: swiper, accordion, tab, dialog, scroll/counter animation.
- **Swiper init + destroy logic:** see `references/swiper.md` § JS.
- JS rules: no `var`, `const` default, tabs, camelCase, no spaces inside JS parentheses. JS-only DOM hooks use `js-*` prefix.

## Step 8 — Output policy

Silent by default. Final response = a one-line confirmation that the block files are written, plus up to 3 bullet flags for unresolved issues (heading-class ambiguity, dimensions the design omitted, Swiper-vs-static ambiguity that was resolved by asking, dead CSS, button sizing diffs, etc.). In note mode, the confirmation line should mention that `/frontend-design` was used to materialize the reference, so the user knows which mode ran — but do not surface the reference HTML/CSS itself.

## Step 9 — Visual verification

Default is **skip** — the user previews in their own page. Run only when **either** is true:

- **Explicit user request** — "verify", "screenshot it", "compare to Figma", "/verify", or any clear ask to check the rendered output against the design.
- **Your own judgment says it's worth it** — trigger verification yourself when translation risk is high enough that a screenshot will likely catch an issue you can't catch by reading the SCSS:
  - Swiper wiring with `matchMedia` destroy logic (Step 3 wired a slider).
  - Two or more LAYOUT media queries, or a layout that flips between flex / grid / absolute positioning.
  - Overlapping elements, negative margins, `position: absolute` over a sibling, or any z-index dependency.
  - A pattern you haven't used in this project before (first slider, first grid-template-areas block, etc.).

  Skip for low-risk blocks: value-only diffs, pure text/content blocks, single-column stacks, simple two-column rows with no overlap.

**Hard opt-out:** if the user said "skip verification" / "no screenshots" / "don't run playwright" anywhere in the conversation, don't run it regardless of judgment.

Steps when running (use the **`playwright-cli` skill** — don't shell to `playwright` directly):

1. Write the slug (no quotes, no newline) to `blocks/.claude-preview-pending`. The WP `init` hook in `functions/claude-preview.php` reads it and inserts the block on the "claude" page on the next request. The trigger file persists across requests, so reloads work without rewriting it.
2. Read `LOCAL_URL` from `.env`.
3. Invoke `playwright-cli` → navigate to `{LOCAL_URL}/claude/`. Wait for fonts and images.
4. Element-scoped screenshot of `.{slug}-section` at **375px** → `screenshots/{slug}-render-375.png`.
5. Element-scoped screenshot at **1440px** → `screenshots/{slug}-render-1440.png`.
6. Compare each to the matching design — the Figma frame in Figma mode, or the `/frontend-design` reference HTML rendered at the same viewport in note mode (you already have it in context from Step 1a). Iterate up to 2 rounds.
7. `playwright-cli close` at the end.

If you trigger verification on your own judgment (no explicit ask), say so in one sentence before starting (e.g. "Running a quick screenshot pass — slider destroy logic is the kind of thing that's easy to get wrong.") so the user can interrupt if they'd rather skip.

## Constraints

- **Buttons:** never add or edit `.btn*` rules — owned by `_buttons.scss`. Flag button sizing diffs.
- **Images:** save to `assets/images/`, not the block folder.
- **Container padding** (`$container-padding-x`) is site-wide. Don't match a Figma `p-16` by editing the block.
- **Dead BEM rules** (`__button-label`, etc.) in legacy blocks: flag, don't delete.
- **Top-level selectors** in existing `{slug}.scss`: flag and fix only if trivial.
- **Scope:** only edit `blocks/{slug}/{slug}.{php,scss,json,js}`. Never edit `index.php`, `header.php`, `footer.php`, `src/sass/style.scss`, `src/sass/**` partials, or other blocks. Reading other blocks as a structural reference is fine; editing them is not.
- **No `!important`, no inline styles, no jQuery, no `nl2br()`** (use `white-space: pre-line`).

## Validation checklist

After writing files, run the deterministic project-wide checks via the `wp-checklist` skill — it owns JSON key prefix (`field_{slug}_`), no auto-injected dev fields, image `return_format: id` + `preview_size: w200`, `abstracts-blocks` import, `.{slug}-section` root selector, no BEM `&__` / `&--` shorthand, no `@include font/text`, no top-level `@media`, and no desktop-first / raw-px media queries. Don't re-list those here — single source of truth.

This skill's own checklist covers only items wp-checklist does NOT verify (block-specific, design-driven, or workflow-output):

- [ ] JSON specifics not covered by wp-checklist: repeater `collapsed` = first sub-field; links `return_format: array`; `needs_swiper: true` if applicable.
- [ ] SCSS specifics not covered by wp-checklist: no `padding-inline` on the section wrapper; no `fluid(0, X)` placeholders; logical properties throughout.
- [ ] LAYOUT media queries contain only structural properties (no font / padding / gap inside).
- [ ] PHP: every field that can't be JSON-pre-seeded has a fallback; `.container` is the only direct `<section>` child; `foreach` guards in place; output escaped.
- [ ] Every content element has `data-inview` + `data-aos="fade-up"` (skip pure structural wrappers like `.container`, `.swiper-wrapper`).
- [ ] Swiper (if wired): `.swiper-wrapper > .swiper-slide`; `min-inline-size: 0` on `.swiper`; destroy logic matches Step 3; slide widths use `inline-size`, not `flex: 0 0 …`.
- [ ] If verification was opted in: `blocks/.claude-preview-pending` written; both 375px and 1440px screenshots taken.
- [ ] If note mode was used: `/frontend-design` was invoked once, its output stayed in-context only (nothing under `blocks/{slug}/` traces back to the reference HTML/CSS), and the block's typography / colors / layout all came from that reference.
