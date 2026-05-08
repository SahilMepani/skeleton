---
name: wp-block
description: Builds a complete ACF Gutenberg block (PHP + SCSS + JSON + JS) from a mobile + desktop Figma pair in one pass. Reads both designs first, inlines typography directly with fluid(mobile, desktop), and wires Swiper up front when mobile is a slider but desktop is static. Only invoke when explicitly called via /wp-block.
metadata:
    mcp-server: figma, figma-desktop, playwright
---

# Block — One-pass Figma → ACF block (mobile + desktop)

Translates **two** Figma nodes (mobile + desktop) into PHP + SCSS + JSON + JS in a single pass. Seeing both designs up front lets the skill make heading-class and Swiper decisions correctly the first time — no `fluid(0, X)` placeholders, no late slider rewrites.

> General SCSS / PHP / JS / accessibility / ACF JSON rules already live in `CLAUDE.md`, `.cursor/AGENTS.md` (always loaded), and `.cursor/rules/*.mdc` (read on demand). This skill covers only what's specific to the two-design workflow.

## Configuration

<!-- Toggle visual verification mode. Change the value to flip behavior of Step 9. -->

- **`visual-verification`**: `required` ← change to `optional` to keep it auto-judged, or back to `required` to always run Step 9.

## Prerequisites

- Figma MCP connected.
- Block exists at `blocks/{slug}/` and is registered in `blocks/config.php`. If not, ask the user to register it first.

## Inputs

Two Figma URLs:
- **Mobile design** (typically a 375px frame).
- **Desktop design** (typically 1440px+).

Extract `fileKey` + `nodeId` from each URL: `figma.com/design/:fileKey/...?node-id=1-2` → `nodeId = 1:2`. If the user supplies only one URL, ask for the other before doing any work.

## Step 1 — Fetch both designs (parallel)

Run four calls in parallel:

1. `get_design_context(mobileFileKey, mobileNodeId)`
2. `get_screenshot(mobileFileKey, mobileNodeId)`
3. `get_design_context(desktopFileKey, desktopNodeId)`
4. `get_screenshot(desktopFileKey, desktopNodeId)`

`get_design_context` already returns screenshot + layout + typography + colors + asset URLs; the explicit `get_screenshot` calls are insurance for higher-fidelity image data when the bundled screenshot is lossy. Fidelity over token cost.

If a response is truncated, fall back to `get_metadata` and fetch children individually for the affected design.

## Step 2 — Diff the two designs (silent, internal)

Build an internal table per element. Never output it.

| Element / Selector | Mobile | Desktop | Decision |
| --- | --- | --- | --- |

Decision rules:

- **VALUE** (same layout, different number) → `fluid(mobile, desktop)` directly in SCSS. If `mobile == desktop` → static `rem-calc(X)` for px, plain number for unitless. **Never emit `fluid(0, X)` placeholders.**
- **LAYOUT** (flex-direction, grid-template-columns, order, display change, flex-wrap, position, `max-inline-size` unconstrained → fixed) → mobile-first base + `@media (width >= $md)` containing **only** the differing structural properties. No font / padding / gap inside the MQ.
- **TYPOGRAPHY** → always inline `font-size: fluid(mobile, desktop); line-height: ...; font-family: ...;` in block SCSS. Never apply `.h1`–`.h6` classes; never `@include font(...)` or `@include text(...)`.
- **SLIDER** → flag for Step 3.

Default to VALUE when unsure. Goal: minimize media queries.

`fluid()` mechanics: `fluid($min, $max, $min-bp: 'md', $max-bp: 'xl')` → `clamp()`. Below 768px → `$min`. Above 1200px → `$max`. Don't widen the third/fourth args without an explicit reason.

Slider behavior signals on a viewport: horizontal overflow strip, dots / arrows, off-canvas card edges, slide-shaped cards spilling past the right edge.

## Step 3 — Decide Swiper wiring up front

Cross-reference both designs:

- **Mobile slider + desktop static/grid** → wire Swiper with `matchMedia` destroy-above-`$md`. Below `$md` Swiper runs; at/above `$md` it's destroyed and CSS owns the layout.
- **Mobile slider + desktop slider** → wire Swiper at all sizes, no destroy logic.
- **Both static** → no Swiper.
- **Ambiguous** (e.g. mobile cards spill off the right but it's unclear whether they paginate) → **ask the user** with a single targeted question, then proceed. Do not write code first.

## Step 4 — Write `{slug}.json`

- Field key prefix: `field_{slug}_{field_name}`. Sub-fields: `field_{slug}_{repeater}_{field}`.
- Structure: `accordion` (open=1, multi_expand=1) → `tab` → fields.
- **Never add Settings / Spacing / Display fields** — auto-injected at registration.
- Images: `"return_format": "id"`, `"preview_size": "w200"`.
- Links: `"return_format": "array"`.
- Repeaters: `"collapsed"` = key of first sub-field.
- **Default values from Figma:** put placeholder copy in `default_value` for any field type that supports it (text, textarea, number, email, url, range, password, select, radio, checkbox, button_group, true_false, color/date/time pickers, wysiwyg). PHP must not duplicate these — Step 6 only carries fallbacks for field types that can't take `default_value` (image, file, gallery, link, repeater, group, flexible_content, clone, post_object, page_link, relationship, taxonomy, user).
- Add `"needs_swiper": true` if Step 3 wired Swiper.
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
- **Swiper SCSS** (when wired):
  - `.{block}-slider { inline-size: 100%; min-inline-size: 0; overflow: visible; }`
  - Slide widths: `inline-size: rem-calc(X); max-inline-size: 90%;` — **not** `flex: 0 0 rem-calc(X)`.
  - No `overflow-x: auto` on the wrapper — Swiper owns overflow.
- `#{…}` Sass interpolation required inside CSS `min()` / `max()`.

## Step 6 — Write `{slug}.php`

General PHP rules (tab indent, escape every output, `'skel'` text domain) are in CLAUDE.md / `.cursor/rules/php-standards.mdc`. Block-specific:

- Use the standard section wrapper from `.cursor/rules/project-patterns.mdc` §Block Template Structure: `skel_render_block_preview` early-return, `skel_should_display_block` early-return, `skel_get_block_developer_options` for spacing/display/custom-class plumbing, `<section class="{slug}-section section ...">` with `.container` as the **only** direct child.
- **Defaults policy — JSON first.** Field types that support ACF `default_value` (`text`, `textarea`, `number`, `email`, `url`, `range`, `password`, `select`, `radio`, `checkbox`, `button_group`, `true_false`, color/date/time pickers, `wysiwyg`) carry their Figma placeholder copy in `{slug}.json` from Step 4 — PHP just calls `get_field()` for those, no `?:` / `??`. Add PHP fallbacks **only** for field types ACF cannot pre-seed: `image` (→ `DEFAULT_THUMBNAIL_ID`), `link` (→ `array( 'url' => '#', 'title' => '…', 'target' => '' )`), `repeater` / `group` / `flexible_content` (→ a small placeholder array shaped like the Figma design — typically 2–3 rows), `gallery` / `file`, and the relationship-style fields (`post_object`, `page_link`, `relationship`, `taxonomy`, `user`). Keep Figma copy in those PHP arrays so the block renders on a fresh insert.
- **Repeater normalization:** if a repeater only collects one useful value per row, normalize before rendering (e.g. `wp_list_pluck`) instead of carrying nested arrays through the loop.
- **Image output:** `wp_get_attachment_image()` with `loading => 'lazy'` and a sensible `sizes`. Custom sizes: `w480`, `w768`, `w1400`, `w1920`. Full-bleed images use `img-cover` inside `img-cover-block`. Linked images: add `img-link` to the `<a>`.
- **Heading markup:** never apply `.h1`–`.h6` classes. Use semantic tags (`<h2>`, `<h3>`, etc.) and let block SCSS own the size via inline `font-size` / `line-height` / `font-family`.
- **Swiper markup** (when wired): wrap items in `.{block}-slider.swiper > .swiper-wrapper > .swiper-slide`. If a Swiper-using block already exists in this project, read it as a structural reference (read-only).
- **Animation attributes (MANDATORY):** every visible content element rendered by the block (headings, paragraphs, images, cards, buttons, list items, slides, etc.) must have **both** `data-inview` and `data-aos="fade-up"` attributes. The project's AOS system (`src/js/custom/data-inview.js` + `src/sass/partials/aos/`) requires both — `data-inview` triggers the IntersectionObserver, `data-aos="fade-up"` selects the animation. Pure structural wrappers (`.container`, `.swiper-wrapper`, `.swiper-slide` itself, decorative-only `<div>`s used purely for layout) do NOT need them. Inside `foreach`/`while` loops, add the attributes to each rendered item element (e.g. each card, each slide's content). When in doubt, add them — the system handles `prefers-reduced-motion` and is idempotent. Default to `fade-up`; only deviate (`fade`, `fade-left`, etc.) if the Figma frame has explicit motion direction notes.
  - Example: `<h2 data-inview data-aos="fade-up"><?php echo esc_html( $title ); ?></h2>`, `<article class="card" data-inview data-aos="fade-up">…</article>`.
- Guard every `foreach` with `if ( is_array( $items ) && ! empty( $items ) ) :`.

## Step 7 — Write `{slug}.js`

- Default: leave the auto-generated stub `(() => { })();`.
- Need JS for: swiper, accordion, tab, dialog, scroll/counter animation.
- **Swiper init:** follow `.cursor/rules/swiper-standards.mdc` §2 — scoped navigation/pagination wiring, single-slide bailout, `slidesPerView: 'auto'` + `spaceBetween` for variable-width slides.
- **Destroy logic** from Step 3:
  - Mobile slider + desktop static → `matchMedia('(min-width: ${$md}px)')` listener; instantiate below `$md`, destroy at/above.
  - Slider at all sizes → no destroy logic.
- JS rules: no `var`, `const` default, tabs, camelCase, no spaces inside JS parentheses. JS-only DOM hooks use `js-*` prefix.

## Step 8 — Output policy

Silent by default. Final response = a one-line confirmation that the block files are written, plus up to 3 bullet flags for unresolved issues (heading-class ambiguity, dimensions Figma omitted, Swiper-vs-static ambiguity that was resolved by asking, dead CSS, button sizing diffs, etc.).

## Step 9 — Visual verification

**Mode:** controlled by the `visual-verification` toggle in the Configuration block at the top of this skill.

- **`required`** → always run this step after Step 7, regardless of explicit ask or risk judgment. Skip the opt-in / auto-judged logic below.
- **`optional`** (default) → use the opt-in / auto-judged logic below. Default action is **skip**; the user previews in their own page.

### When `optional`, run only when **either** of the following is true:

- **Explicit user request** — "verify", "screenshot it", "compare to Figma", "/verify", or any clear ask to check the rendered output against the design.
- **Your own judgment says it's worth it** — trigger verification yourself when translation risk is high enough that a screenshot will likely catch an issue you can't catch by reading the SCSS:
  - Swiper wiring with `matchMedia` destroy logic (Step 3 wired a slider).
  - Two or more LAYOUT media queries, or a layout that flips between flex / grid / absolute positioning.
  - Overlapping elements, negative margins, `position: absolute` over a sibling, or any z-index dependency.
  - A pattern you haven't used in this project before (first slider, first grid-template-areas block, etc.).

  Skip for low-risk blocks: value-only diffs, pure text/content blocks, single-column stacks, simple two-column rows with no overlap.

**Hard opt-out (applies in both modes):** if the user said "skip verification" / "no screenshots" / "don't run playwright" anywhere in the conversation, do not run it regardless of mode or judgment.

Steps when running:

1. Write the slug (no quotes, no newline) to `blocks/.claude-preview-pending`. The WP `init` hook in `functions/claude-preview.php` reads it and inserts the block on the "claude" page on the next request. The trigger file persists across requests, so reloads work without rewriting it.
2. Read `LOCAL_URL` from `.env`.
3. `playwright-cli` → navigate to `{LOCAL_URL}/claude/`. Wait for fonts and images.
4. Element-scoped screenshot of `.{slug}-section` at **375px** → `screenshots/{slug}-render-375.png`.
5. Element-scoped screenshot at **1440px** → `screenshots/{slug}-render-1440.png`.
6. Compare each to the matching Figma frame. Iterate up to 2 rounds.
7. `playwright-cli close` at the end.

If you choose to run verification on your own judgment (no explicit ask, `optional` mode), say so in one sentence before starting (e.g. "Running a quick screenshot pass — slider destroy logic is the kind of thing that's easy to get wrong.") so the user can interrupt if they'd rather skip. In `required` mode, just announce in one sentence that verification is running per the skill's configuration.

## Constraints

- **Buttons:** never add or edit `.btn*` rules — owned by `_buttons.scss`. Flag button sizing diffs.
- **Images:** save to `assets/images/`, not the block folder.
- **Container padding** (`$container-padding-x`) is site-wide. Don't match a Figma `p-16` by editing the block.
- **Dead BEM rules** (`__button-label`, etc.) in legacy blocks: flag, don't delete.
- **Top-level selectors** in existing `{slug}.scss`: flag and fix only if trivial.
- **Scope:** only edit `blocks/{slug}/{slug}.{php,scss,json,js}`. Never edit `index.php`, `header.php`, `footer.php`, `src/sass/style.scss`, `src/sass/**` partials, or other blocks. Reading other blocks as a structural reference is fine; editing them is not.
- **No `!important`, no inline styles, no jQuery, no `nl2br()`** (use `white-space: pre-line`).
- **Never `@include font(...)` or `@include text(...)`, and don't apply `.h1`–`.h6` classes** — always inline `font-size` / `line-height` / `font-family` / `font-weight` with `fluid()`.

## Validation checklist

- [ ] JSON: keys prefixed `field_{slug}_`; no Settings/Spacing/Display; repeater `collapsed` = first sub-field; images `return_format: id` + `preview_size: w200`; links `return_format: array`; `needs_swiper: true` if applicable.
- [ ] SCSS: `abstracts-blocks` import; everything nested in `.{slug}-section`; plain child names; no `padding-inline` on the section; no `fluid(0, X)` placeholders; logical properties throughout.
- [ ] No `.h1`–`.h6` classes in markup; no `@include font/text` in SCSS — typography inlined via `font-size: fluid(...)`.
- [ ] LAYOUT media queries contain only structural properties.
- [ ] PHP: every field has a fallback; `.container` is the only direct `<section>` child; `foreach` guards in place; output escaped.
- [ ] Every content element has `data-inview` + `data-aos="fade-up"` (skip pure structural wrappers like `.container`, `.swiper-wrapper`).
- [ ] Swiper (if wired): `.swiper-wrapper > .swiper-slide`; `min-inline-size: 0` on `.swiper`; destroy logic matches Step 3; slide widths use `inline-size`, not `flex: 0 0 …`.
- [ ] If verification was opted in: `blocks/.claude-preview-pending` written; both 375px and 1440px screenshots taken.
