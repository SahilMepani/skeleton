---
name: html-block
description: Builds a fully responsive HTML block from a pair of Figma URLs (mobile + desktop) in this static HTML/SCSS project. Produces a PHP partial + SCSS with real fluid(mobile, desktop) values and mobile-first @media for layout flips, then wires the block in and visually verifies at 375/768/1440. Only invoke when explicitly called via /html-block. Static HTML/SCSS only — never React/Tailwind/ACF.
metadata:
    mcp-server: figma, figma-desktop, playwright
---

# HTML Block — Build a Fully Responsive Block from Two Figma URLs

## Overview

Single-pass replacement for running `/acf-block-from-figma` then `/mobile-block`. You receive **both** designs upfront (mobile + desktop), so the SCSS is written with real `fluid(mobileVal, desktopVal)` numbers from the start — no `fluid(0, X)` placeholder phase.

Output: **PHP include partial + SCSS + optional vanilla JS**, fully wired into `index.php` / `header.php` / (`footer.php` if JS), and visually verified at three viewports.

> **Project reality:** static HTML/SCSS site. PHP is only a `require` partial mechanism. No WordPress, no ACF, no block registration, no React, no Tailwind. Despite the name of the sibling skill, `acf` is a misnomer.

## Configuration

<!-- Toggle visual verification mode. Change the value to flip behavior of Step 12. -->

- **`visual-verification`**: `required` ← change to `optional` to use opt-in / auto-judged logic, or back to `required` to always run the three-viewport pass.

## Invocation

```
/html-block <mobileFigmaUrl> <desktopFigmaUrl>
```

- **Positional, mobile first, desktop second.**
- If either URL is missing, ask the user once.
- Block slug comes from the desktop frame name (e.g. "About Bio" → `about-bio`) unless the user has already named one in conversation.
- **If `blocks/{slug}/` already exists, STOP and ask the user before overwriting.** Do not silently overwrite prior work.

## Prerequisites

- Figma MCP server connected.
- Both URLs follow `https://figma.com/design/:fileKey/:fileName?node-id=:nodeId` — extract `fileKey` and `nodeId` from each (convert `-` to `:` in nodeId).

## Required Workflow

Follow the steps in order. Do not skip steps.

### Step 1 — Get both Figma designs (parallel)

Run four calls in parallel:

1. `get_design_context(mobileFileKey, mobileNodeId)`
2. `get_screenshot(mobileFileKey, mobileNodeId)`
3. `get_design_context(desktopFileKey, desktopNodeId)`
4. `get_screenshot(desktopFileKey, desktopNodeId)`

`get_design_context` returns screenshot + layout + typography + colors + asset URLs; the explicit `get_screenshot` calls are insurance for higher-fidelity image data when the bundled screenshot is lossy. Fidelity over token cost.

If any response is truncated, fall back to `get_metadata` for that frame and fetch child nodes individually.

### Step 2 — Diff the two designs (silent, internal)

Build an internal table per element. **Never output it.**

| Element / Selector | Mobile | Desktop | Decision |
| --- | --- | --- | --- |

Decision rules:

- **VALUE** (same layout, different number) → `fluid(mobile, desktop)` directly in SCSS. If `mobile == desktop` → static `rem-calc(X)` for px, plain number for unitless. **Never emit `fluid(0, X)` placeholders.** **Never emit `fluid(X, X)`** — collapse to `rem-calc(X)`.
- **LAYOUT** (flex-direction, grid-template-columns, order, display change, flex-wrap, position, `max-inline-size` unconstrained → fixed) → mobile-first base + `@media (width >= $md)` containing **only** the differing structural properties. No font / padding / gap inside the MQ.
- **TYPOGRAPHY** → always inline `font-size: fluid(mobile, desktop); line-height: ...; font-family: ...; font-weight: ...;` in block SCSS. **Never** apply `.h1`–`.h6` classes; **never** `@include font(...)` or `@include text(...)`.
- **SLIDER** → flag for Step 3.

Default to VALUE when unsure. Goal: minimize media queries.

`fluid()` mechanics: `fluid($min, $max, $min-bp: 'md', $max-bp: 'xl')` → `clamp()`. Below 768px → `$min`. Above 1200px → `$max`. Don't widen the third/fourth args without an explicit reason.

Slider behavior signals on a viewport: horizontal overflow strip, dots / arrows, off-canvas card edges, slide-shaped cards spilling past the right edge.

### Step 3 — Decide Swiper wiring up front

Cross-reference both designs:

- **Mobile slider + desktop static/grid** → wire Swiper with `matchMedia` destroy-above-`$md`. Below `$md` Swiper runs; at/above `$md` it's destroyed and CSS owns the layout.
- **Mobile slider + desktop slider** → wire Swiper at all sizes, no destroy logic.
- **Both static** → no Swiper.
- **Ambiguous** (e.g. mobile cards spill off the right but it's unclear whether they paginate) → **ask the user** with a single targeted question, then proceed. Do not write code first.

### Step 4 — Determine slug; refuse to clobber

1. Derive slug from the desktop frame name.
2. Check `blocks/{slug}/`. If it exists, **stop** and ask the user how to proceed (rename, overwrite, abort). Do not continue automatically.

### Step 5 — Scaffold from `blocks/blank/`

There is no auto-generation and no `blocks/config.php`.

1. Copy `blocks/blank/blank.php` → `blocks/{slug}/{slug}.php`
2. Copy `blocks/blank/blank.scss` → `blocks/{slug}/{slug}.scss`
3. **Do not copy** `blank.css` / `blank.css.map` (build output — regenerated).
4. JS file is created only in Step 10 if actually needed.

**Gotcha:** `blocks/blank/blank.php` ships with a stale hardcoded class `heading-text-section`. Replace it with `{slug}-section` immediately — never leave the blank class behind.

### Step 6 — Read project conventions (before writing any SCSS)

Read these for shared spacing / radii / breakpoints, and for live block patterns:

- `src/sass/partials/config/_variables.scss` — shared spacing, radii, misc
- `src/sass/partials/config/_breakpoints.scss` — breakpoint map (rarely needed)
- `.cursor/rules/snippets.mdc` — block patterns, repeater/link/image snippets, JS patterns (swiper, accordion, dialog)
- `.cursor/rules/scss-standards.mdc` — SCSS rules
- `.cursor/rules/examples/scss-block-template.scss` — canonical SCSS block structure
- `.cursor/rules/examples/js-module-template.js` — canonical JS pattern

Skim a real reference block (e.g. `blocks/home-hero/`) for live conventions.

> **Typography & colors policy:** typography is **inlined** per Step 2's TYPOGRAPHY rule (no `_typography.scss` mappings, no `.h1`–`.h6` classes, no `@include font/text`). Colors are **inlined as Figma hex** — no token-mapping pass. The `_typography.scss` and `_colors.scss` partials still exist for global / non-block uses; the block-authoring workflow does not reach for them.

### Step 7 — Extract images at 2x to `assets/images/`

Any raster images (photos, illustrations, decorative PNGs) must be exported from Figma and saved to `assets/images/` — **never** the block folder.

- Scale: **2x** (non-negotiable).
- Format: PNG for photos / transparency, SVG for icons / vector art (scale doesn't apply to SVG).
- Destination: `assets/images/{descriptive-name}.png`.
- Markup references the 2x file directly (`/assets/images/{name}.png`); the browser handles DPR via CSS sizing. Do not generate `@1x`/`@2x` pairs unless asked.

### Step 8 — Write the PHP markup (from the desktop design)

Edit `blocks/{slug}/{slug}.php`. Plain HTML fragment wrapped in a `<section>`. No PHP logic, no WordPress functions, no ACF field calls. Hardcode content from the desktop Figma frame (mobile and desktop share the same content — only layout/values differ).

**Mandatory structure:**

```php
<section class="{slug}-section section">
    <div class="container">
        <!-- ALL block content goes here -->
    </div>
</section>
```

**Container rule (non-negotiable):** `.container` is the **first and only direct child** of the section. Every heading, image, grid, button — everything from the design — sits inside `.container`. Never place siblings next to `.container`, never omit it.

**Corollary — never set `padding-inline` on `.{slug}-section`.** Horizontal gutters come from `.container` globally (`$container-padding-x`). Only `padding-block-*` belongs on the section.

**Markup rules:**

- **Class naming (no BEM `__`):** outer = `.{slug}-section`. Children use **plain descriptive names** (`.card`, `.image`, `.body`, `.tag`, `.brand`, `.price`) — NEVER `.{slug}__card`. Uniqueness comes from SCSS nesting, not class prefixes.
- **Modifiers keep `--`:** `.tag--dark`, `.tag--sand`, `.btn--primary`. Only the `__` separator is banned.
- **Semantic HTML:** `<article>`, `<header>`, `<h2>`/`<h3>`, `<button>`, `<nav>` where appropriate — not `<div>` soup.
- **Heading hierarchy:** no skipped levels (`h2` for section, `h3` for cards).
- **Heading classes:** never apply `.h1`–`.h6` classes. Use semantic tags (`<h2>`, `<h3>`, etc.) and let block SCSS own the size via inline `font-size` / `line-height` / `font-family`.
- **Images:** descriptive `alt` on informative images, `alt=""` on decorative ones. Path: `/assets/images/{name}.png`.
- **Interactive toggles/accordions:** `aria-expanded="false"` + `aria-controls` pointing to a panel `id`.
- **Icon-only buttons:** include `<span class="screen-reader-text">Label</span>`.
- **External links:** the link snippet in `snippets.mdc` already includes an `(opens in a new tab)` sr-only span — keep it.
- **Swiper markup** (when wired per Step 3): wrap items in `.{slug}-slider.swiper > .swiper-wrapper > .swiper-slide`. Standard nav classes only: `.swiper-navigation`, `.swiper-button-prev`, `.swiper-button-next` — never block-specific nav classes.
- **Animation attributes (MANDATORY):** every visible content element in the block (headings, paragraphs, images, cards, buttons, list items, slides, etc.) must have **both** `data-inview` and `data-aos="fade-up"` attributes. The project's AOS system (`src/js/custom/data-inview.js` + `src/sass/partials/aos/`) requires both — `data-inview` triggers the IntersectionObserver, `data-aos="fade-up"` selects the animation. Pure structural wrappers (`.container`, `.swiper-wrapper`, `.swiper-slide` itself, decorative-only `<div>`s used purely for layout) do NOT need them. When in doubt, add them — the system handles `prefers-reduced-motion` and is idempotent. Default to `fade-up`; only deviate (`fade`, `fade-left`, etc.) if the Figma frame has explicit motion direction notes.
  - Example: `<h2 data-inview data-aos="fade-up">Title</h2>`, `<article class="card" data-inview data-aos="fade-up">…</article>`.
- Content text comes verbatim from Figma.
- Full a11y patterns: `.cursor/rules/accessibility.mdc`.

### Step 9 — Write the SCSS (single pass, both designs)

Edit `blocks/{slug}/{slug}.scss`. Boilerplate import is already present:

```scss
@use '../../src/sass/partials/abstracts-blocks' as *;
```

> If you see `abstracts` instead of `abstracts-blocks`, correct it.

**Structural invariant (MANDATORY):**

**ALL CSS MUST be nested inside the outer `.{slug}-section { … }` selector.** No top-level selectors outside that wrapper — not even `@media`, not even shared utilities. Every child, descendant, pseudo-class, modifier, and media query nests inside `.{slug}-section`. This is how uniqueness is achieved without BEM prefixes.

CSS inside the wrapper may target direct children **or any descendant depth**. The only rule: nothing lives outside `.{slug}-section`.

**Apply Step 2's diff-table decisions:**

- **VALUE** rows → `fluid(mobile, desktop)` or static `rem-calc(X)` when values match.
- **LAYOUT** rows → mobile base + `@media (width >= $md) { ... }` for structural properties only. No font / padding / gap inside the MQ.
- **TYPOGRAPHY** rows → inline `font-size: fluid(mobile, desktop); line-height: ...; font-family: ...; font-weight: ...;`. Never apply `.h1`–`.h6` classes; never `@include font(...)` or `@include text(...)`.
- **Color values** inline as Figma hex. No token-mapping pass.

**Spacing & value rules:**

| Property | Format | Example |
|---|---|---|
| Most px values | `fluid(mobile, desktop)` | `font-size: fluid(14, 18)` |
| Margins | `fluid(mobile, desktop)` | `margin-block-end: fluid(12, 16)` |
| Letter-spacing | Raw `em` | `letter-spacing: -0.02em` |
| Line-height | Unitless ratio | `line-height: 1.5` |
| Very small (1–3px) | Raw px OK | `border: 1px solid` |
| Equal across breakpoints | `rem-calc(N)` | `border-radius: rem-calc(8)` |

**CSS logical properties (MANDATORY):**

| Physical (NEVER) | Logical (ALWAYS) |
|---|---|
| `margin-top/bottom` | `margin-block-start/end` |
| `margin-left/right` | `margin-inline-start/end` |
| `padding-top/bottom` | `padding-block-start/end` |
| `padding-left/right` | `padding-inline-start/end` |
| `width` / `height` | `inline-size` / `block-size` |
| `min-width` / `max-width` | `min-inline-size` / `max-inline-size` |
| `min-height` / `max-height` | `min-block-size` / `max-block-size` |
| `top/bottom/left/right` | `inset-block-start/end`, `inset-inline-start/end` |
| `border-top/bottom` | `border-block-start/end` |
| `border-left/right` | `border-inline-start/end` |
| `border-radius: TL TR BR BL` | `border-start-start-radius`, etc. |

**Mobile-first `@media`:** every media query is `@media (width >= $bp)`, never `< $bp`. Mobile is the default; desktop is the progressive enhancement. Nest the MQ inside `.{slug}-section` (or inside a nested child) — never at file root. The MQ contains **only** differing structural properties — no font-sizes, no padding scaling, no gap scaling inside `@media` (those live in `fluid()`).

**Class & nesting rules:**

- Plain child names (`.card`, `.image`, `.title`) — no BEM `__` prefix.
- Modifiers keep `--` and are written **in full** (`.tag--primary`) — no `&--primary` / `&__child` shorthand.
- No SCSS `&__` / `&--` nesting shorthand.

**Layout rules:**

- **NO flex for gap-only spacing** — only `display: flex` for actual row/column layouts. Vertical spacing between stacked elements: `margin-block-end` on the element.
- Functions: `rem-calc(16)` for fixed equal values, `fluid(min, max)` for responsive ones.
- `#{…}` Sass interpolation required inside CSS `min()` / `max()` for Sass compatibility.
- No stylelint directives.

**Swiper SCSS** (when wired per Step 3):

- `.{slug}-slider { inline-size: 100%; min-inline-size: 0; overflow: visible; }`
- Slide widths: `inline-size: rem-calc(X); max-inline-size: 90%;` — **not** `flex: 0 0 rem-calc(X)`.
- No `overflow-x: auto` on the wrapper — Swiper owns overflow.

**Minimal skeleton:**

```scss
.{slug}-section {
    padding-block: fluid(48, 80);

    .header {
        display: flex;
        flex-direction: column;
        gap: fluid(8, 16);

        @media (width >= $md) {
            flex-direction: row;
        }
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: rem-calc(24);

        @media (width >= $md) {
            grid-template-columns: repeat(4, 1fr);
            gap: rem-calc(16);
        }
    }

    .title {
        font-family: 'Libre Baskerville', serif;
        font-size: fluid(24, 40);
        line-height: 1.4;
        font-weight: 400;
        color: #362925;
    }

    .tag--primary { /* full modifier class, not &--primary */ }
}
```

**Quick reference (skip re-reading config files when these match):**

| Category | Values |
|---|---|
| Fonts (family names — for the inline `font-family:` value) | `'Libre Baskerville'` (serif), `'Geist'` (sans-serif) — fall back to system stacks |
| Spacing | `$container-padding-x: fluid(20, 40)` (site-wide; do not redeclare on the section) |
| Figma sp tokens | `sp-N` = N px (2,4,6,8,12,16,24,32,48). Radius: `xxs=4 xs=6 sm=8 md=12 lg=16 xl=24` |

### Step 10 — Write JS (only if needed)

Assess from designs + Step 8 markup whether JS is required.

- **Requires JS:** Swiper slider, accordion, tab switching, dialog, counter / scroll animations.
- **Does NOT require JS:** static grids, text/image layouts, pure CSS layouts.

If not needed, **skip the file entirely**. Most blocks have no JS.

If needed, create `blocks/{slug}/{slug}.js`. All JS uses the IIFE pattern. See `.cursor/rules/examples/js-module-template.js` and existing examples (`blocks/testimonials/testimonials.js`, `blocks/faqs/faqs.js`).

**Swiper destroy logic from Step 3:**

- Mobile slider + desktop static → `matchMedia('(min-width: ${$md}px)')` listener; instantiate below `$md`, destroy at/above.
- Slider at all sizes → no destroy logic.

**Swiper init pattern** (copy exactly, adapt options):

```js
(() => {
    if (typeof Swiper === 'undefined') {
        console.warn('Swiper is not loaded');
        return;
    }

    const sliders = document.querySelectorAll('.{slug}-slider');

    sliders.forEach((el, i) => {
        const swiperClass = `{slug}-slider-${i}`;
        el.classList.add(swiperClass);

        const slides = el.querySelectorAll('.swiper-slide');

        if (slides.length <= 0) return;

        if (slides.length === 1) {
            slides.forEach(slide => slide.classList.add('swiper-slide-active'));
            return;
        }

        if (slides.length > 1) {
            new Swiper(`.${swiperClass}`, {
                slidesPerView: 'auto',
                spaceBetween: 16,
                speed: 500,
                grabCursor: true
            });
        }
    });
})();
```

### Step 11 — Wire the block up (the most-forgotten step)

A block isn't done until it's wired in. Wiring happens in **two or three** places — blocks are **NOT** imported into `src/sass/style.scss`.

**1. `index.php` (root)** — render the block:

```php
<?php require 'blocks/{slug}/{slug}.php'; ?>
```

Follow existing spacing pattern (blank line between requires).

**2. `header.php`** — load the styles:

```html
<link rel="stylesheet" href="/blocks/{slug}/{slug}.css">
```

Add it alongside other block `<link>` tags.

**3. `footer.php`** — only if a JS file was created:

```html
<script src="/blocks/{slug}/{slug}.js"></script>
```

Follow the existing script tag pattern. Skip entirely if no JS file.

### Step 12 — Visual verification

**Mode:** controlled by the `visual-verification` toggle in the Configuration block at the top of this skill.

- **`required`** → always run this step after Step 11, regardless of explicit ask or risk judgment. Skip the opt-in / auto-judged logic below.
- **`optional`** → use the opt-in / auto-judged logic below. Default action is **skip**; the user previews in their own page.

#### When `optional`, run only when **either** of the following is true:

- **Explicit user request** — "verify", "screenshot it", "compare to Figma", "/verify", or any clear ask to check the rendered output against the design.
- **Your own judgment says it's worth it** — trigger verification yourself when translation risk is high enough that a screenshot will likely catch an issue you can't catch by reading the SCSS:
  - Swiper wiring with `matchMedia` destroy logic (Step 3 wired a slider).
  - Two or more LAYOUT media queries, or a layout that flips between flex / grid / absolute positioning.
  - Overlapping elements, negative margins, `position: absolute` over a sibling, or any z-index dependency.
  - A pattern you haven't used in this project before (first slider, first grid-template-areas block, etc.).

  Skip for low-risk blocks: value-only diffs, pure text/content blocks, single-column stacks, simple two-column rows with no overlap.

**Hard opt-out (applies in both modes):** if the user said "skip verification" / "no screenshots" / "don't run playwright" anywhere in the conversation, do not run it regardless of mode or judgment.

If you choose to run verification on your own judgment (no explicit ask, `optional` mode), say so in one sentence before starting (e.g. "Running a quick screenshot pass — slider destroy logic is the kind of thing that's easy to get wrong.") so the user can interrupt if they'd rather skip. In `required` mode, just announce in one sentence that verification is running per the skill's configuration.

**Steps when running:**

**1. Read `LOCAL_URL`** from project root `.env`. Block renders on the base URL because Step 11 wired it into `index.php`.

**2. Screenshot via `/playwright-cli`** at three viewports. Screenshot the **element** `.{slug}-section`, not the full page. Save to `screenshots/{slug}-render-{width}.png`:

- `screenshots/{slug}-render-375.png` — mobile
- `screenshots/{slug}-render-768.png` — mid (catch layout-flip regressions)
- `screenshots/{slug}-render-1440.png` — desktop

Wait for fonts and images before capturing. Close playwright at the end.

**3. Compare:**

- 375 → mobile Figma `get_screenshot` from Step 1.
- 1440 → desktop Figma `get_screenshot` from Step 1.
- 768 → no Figma reference; check the layout flip is clean, no overflow, no broken mid-breakpoint state.

Check on each: layout / element ordering, spacing (proportionally, not pixel-perfect), typography (family/size/weight/line-height/letter-spacing), colors, image sizing/aspect/position, border-radius/shadows, alignment.

**4. Iterate** SCSS (or markup if structural) up to **3 rounds**. After 3, surface remaining diffs to the user instead of looping indefinitely.

**Stopping criteria:**

- Rendered output visually matches both Figma frames with no meaningful discrepancies, OR
- 3 iterations complete and remaining differences reported to the user.

## Output policy

Silent by default. Final response = a one-line confirmation that the block files are written, plus the three screenshots if verification ran, plus up to 3 bullet flags for unresolved issues only (heading-class ambiguity, dimensions Figma omitted, Swiper-vs-static ambiguity that was resolved by asking, dead/legacy CSS noticed, button sizing diff, Figma export failure, unresolved diff after 3 iterations). If the pass was clean and verification ran, screenshots only — no extra text.

## Constraints

**Scope** — only edit:

- `blocks/{slug}/{slug}.php`
- `blocks/{slug}/{slug}.scss`
- `blocks/{slug}/{slug}.js` (only if needed)
- `index.php`, `header.php`, `footer.php` (wiring)
- `assets/images/` (image extraction)

**Never touch:**

- `src/sass/style.scss` (blocks are NOT imported here)
- Config partials (`src/sass/partials/config/*`) — flag a needed change instead
- Other blocks (`blocks/*/`) — reading other blocks as a structural reference is fine; editing them is not.

**Buttons** — never add or edit `.btn*` rules. Buttons are owned by `_buttons.scss`. No block-scoped `.btn` overrides. Flag button sizing diffs in the report.

**Code style:**

- Logical properties only.
- Images → `assets/images/`, never the block folder.
- `@media` scalar form: `width >= $md`, not `map.get($grid-breakpoints, 'md')`.
- `#{…}` interpolation required inside CSS `min()` / `max()` for Sass compatibility.
- No `!important`, no inline styles, no jQuery.

## Gotchas

- **Stale class in `blank.php`** — `heading-text-section` is hardcoded; replace with `{slug}-section` immediately during scaffold.
- **Container padding** is site-wide via `$container-padding-x: fluid(20, 40)`. Don't redeclare `padding-inline` on the section to match Figma side-padding — it's already handled.
- **`fluid(0, X)` is BANNED in this skill.** Both designs are available — write real numbers. The `0` placeholder convention belongs to the two-pass workflow (`/acf-block-from-figma` → `/mobile-block`).
- **`fluid(X, X)` is BANNED.** If mobile and desktop values match, collapse to `rem-calc(X)` (or unitless).
- **Dead legacy BEM** — old blocks may still have `.{slug}__button-label` / `__button-icon` selectors. These are dead (current button system is `.btn .btn-icon .btn-dark .btn-md`). Flag, don't delete. New blocks must NOT reintroduce `__` prefixes. Plain child names only.
- **Top-level selectors in legacy `.scss`** — every rule, modifier, and `@media` nests inside `.{slug}-section`. If you find yourself writing a top-level `@media` or utility, you're doing it wrong. Flag and fix only if trivial when found in legacy blocks.
- **`LOCAL_URL`** lives in `.env` — read it, don't assume.

## Validation Checklist

**Inputs**
- [ ] Both URLs received; mobile first, desktop second
- [ ] Slug determined; `blocks/{slug}/` does not already exist (if it did, user was asked)
- [ ] Swiper decision made up front per Step 3

**Scaffolding**
- [ ] Block folder created by copying from `blocks/blank/`
- [ ] Stale `heading-text-section` class replaced with `{slug}-section`
- [ ] No `.css` / `.css.map` files copied from blank
- [ ] JS file only exists if the block actually needs JS

**SCSS**
- [ ] All rules nested inside `.{slug}-section { … }` — zero top-level selectors
- [ ] Every responsive value is `fluid(mobile, desktop)` with **real numbers** (no `fluid(0, X)`)
- [ ] No `fluid(X, X)` — collapsed to `rem-calc(X)` or unitless when values match
- [ ] All logical properties (no physical margin/padding/width/height)
- [ ] `@media` only for layout flips (grid columns, flex direction, order, display, position) — never to scale a value
- [ ] All `@media` are mobile-first (`width >= $bp`)
- [ ] Import line is `abstracts-blocks` (not `abstracts`)
- [ ] No flex used solely for gap spacing
- [ ] Plain child class names (`.card`, `.image`) — no BEM `__`
- [ ] Modifiers use `--` written in full (`.tag--dark`) — no `&--` / `&__` shorthand
- [ ] No `padding-inline` on `.{slug}-section`
- [ ] No `.h1`–`.h6` classes in markup; no `@include font/text` in SCSS — typography inlined via `font-size: fluid(...)` / `line-height` / `font-family` / `font-weight`
- [ ] Colors written as Figma hex inline — no token-mapping pass

**Markup & A11y**
- [ ] `.container` is the first and only direct child of `.{slug}-section`
- [ ] Semantic HTML; heading hierarchy preserved
- [ ] Informative images have `alt`; decorative have `alt=""`
- [ ] Interactive toggles have `aria-expanded` + `aria-controls`
- [ ] Icon-only buttons have `screen-reader-text`
- [ ] Every content element has `data-inview` + `data-aos="fade-up"` (skip pure structural wrappers like `.container`, `.swiper-wrapper`)

**Images**
- [ ] Extracted to `assets/images/` at 2x scale (not 1x, not in block folder)

**Swiper (if wired)**
- [ ] `.swiper-wrapper > .swiper-slide` markup; `min-inline-size: 0` on `.swiper`
- [ ] Slide widths use `inline-size`, not `flex: 0 0 …`; `max-inline-size: 90%`
- [ ] No `overflow-x: auto` on wrapper
- [ ] Destroy logic matches Step 3 (matchMedia for mobile-only sliders, none for slider-everywhere)
- [ ] Standard nav classes: `.swiper-navigation`, `.swiper-button-prev`, `.swiper-button-next`

**Wiring**
- [ ] `require` added to root `index.php`
- [ ] CSS `<link>` added to `header.php`
- [ ] JS `<script>` added to `footer.php` (only if JS file exists)
- [ ] Block NOT imported into `src/sass/style.scss`

**Verification (when run)**
- [ ] Three screenshots saved: `{slug}-render-375.png`, `{slug}-render-768.png`, `{slug}-render-1440.png`
- [ ] 375 matches mobile Figma, 1440 matches desktop Figma, 768 has no broken state
- [ ] Iterated up to 3 rounds; remaining diffs (if any) reported to the user
