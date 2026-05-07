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

If any response is truncated, fall back to `get_metadata` for that frame and fetch child nodes individually.

Study both designs side by side. Identify:

- Element inventory and hierarchy (should be the same in both).
- **VALUE differences** — same layout, different numbers (font-size, padding, gap, margin, border-radius, fixed sizes). These become `fluid(mobileVal, desktopVal)`.
- **LAYOUT differences** — structural flips (flex-direction, grid-template-columns, order, display, position, max-inline-size unconstrained → fixed). These become mobile-first `@media (width >= $bp)`.
- Interactive patterns (toggles, accordions, sliders, dialogs) — drive Step 6 JS decision and Step 4 ARIA.

### Step 2 — Determine slug; refuse to clobber

1. Derive slug from the desktop frame name.
2. Check `blocks/{slug}/`. If it exists, **stop** and ask the user how to proceed (rename, overwrite, abort). Do not continue automatically.

### Step 3 — Scaffold from `blocks/blank/`

There is no auto-generation and no `blocks/config.php`.

1. Copy `blocks/blank/blank.php` → `blocks/{slug}/{slug}.php`
2. Copy `blocks/blank/blank.scss` → `blocks/{slug}/{slug}.scss`
3. **Do not copy** `blank.css` / `blank.css.map` (build output — regenerated).
4. JS file is created only in Step 6 if actually needed.

**Gotcha:** `blocks/blank/blank.php` ships with a stale hardcoded class `heading-text-section`. Replace it with `{slug}-section` immediately — never leave the blank class behind.

### Step 4 — Read tokens (before writing any SCSS)

Read these so values map to existing tokens instead of being inlined:

- `src/sass/partials/config/_typography.scss` — font families, size scale, weights, line-heights
- `src/sass/partials/config/_colors.scss` — color tokens
- `src/sass/partials/config/_variables.scss` — shared spacing, radii, misc
- `src/sass/partials/config/_breakpoints.scss` — breakpoint map (rarely needed)

Theme conventions:

- `.cursor/rules/snippets.mdc` — block patterns, repeater/link/image snippets, JS patterns (swiper, accordion, dialog)
- `.cursor/rules/theme-config.mdc` — colors, typography scale, breakpoints
- `.cursor/rules/scss-standards.mdc` — SCSS rules
- `.cursor/rules/examples/scss-block-template.scss` — canonical SCSS block structure
- `.cursor/rules/examples/js-module-template.js` — canonical JS pattern

Skim a real reference block (e.g. `blocks/home-hero/`) for live conventions.

> **Token rule:** if Figma uses a color/font-size/spacing matching an existing token, **use the token**. Only fall back to raw hex/values when no token matches; if a new value is shared across blocks, add it to the config partial instead of inlining.

### Step 5 — Extract images at 2x to `assets/images/`

Any raster images (photos, illustrations, decorative PNGs) must be exported from Figma and saved to `assets/images/` — **never** the block folder.

- Scale: **2x** (non-negotiable).
- Format: PNG for photos / transparency, SVG for icons / vector art (scale doesn't apply to SVG).
- Destination: `assets/images/{descriptive-name}.png`.
- Markup references the 2x file directly (`/assets/images/{name}.png`); the browser handles DPR via CSS sizing. Do not generate `@1x`/`@2x` pairs unless asked.

### Step 6 — Write the PHP markup (from the desktop design)

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
- **Images:** descriptive `alt` on informative images, `alt=""` on decorative ones. Path: `/assets/images/{name}.png`.
- **Interactive toggles/accordions:** `aria-expanded="false"` + `aria-controls` pointing to a panel `id`.
- **Icon-only buttons:** include `<span class="screen-reader-text">Label</span>`.
- **External links:** the link snippet in `snippets.mdc` already includes an `(opens in a new tab)` sr-only span — keep it.
- Content text comes verbatim from Figma.
- Full a11y patterns: `.cursor/rules/accessibility.mdc`.

### Step 7 — Write the SCSS (single pass, both designs)

Edit `blocks/{slug}/{slug}.scss`. Boilerplate import is already present:

```scss
@use '../../src/sass/partials/abstracts-blocks' as *;
```

> If you see `abstracts` instead of `abstracts-blocks`, correct it.

**Structural invariant (MANDATORY):**

**ALL CSS MUST be nested inside the outer `.{slug}-section { … }` selector.** No top-level selectors outside that wrapper — not even `@media`, not even shared utilities. Every child, descendant, pseudo-class, modifier, and media query nests inside `.{slug}-section`. This is how uniqueness is achieved without BEM prefixes.

CSS inside the wrapper may target direct children **or any descendant depth**. The only rule: nothing lives outside `.{slug}-section`.

**Single-pass classification — for every property, decide VALUE vs LAYOUT:**

| Kind | Meaning | Treatment |
|---|---|---|
| **VALUE** | Same layout, different number across mobile/desktop | `fluid(mobileVal, desktopVal)` |
| **LAYOUT** | Structural flip (flex direction, grid columns, order, display, wrap, position, max-inline-size unconstrained → fixed) | Mobile-first `@media (width >= $bp)` |

Rules:

- `font-size, line-height, padding, margin, gap, border-radius, fixed sizes` → VALUE.
- `flex-direction, grid-template-columns, order, display changes, flex-wrap, position` → LAYOUT.
- `max-inline-size: unconstrained → fixed` → LAYOUT (clamp can't express "no constraint").
- Default to VALUE when unsure. Goal: minimize media queries.
- If `mobileVal == desktopVal`, **collapse to static** — `rem-calc(X)` for px, plain number for unitless. **Never write `fluid(X, X)`**.
- **Never write `fluid(0, X)` placeholders** — both designs are available, fill real numbers from the start.

**`fluid()` mechanics:** `fluid($min, $max, $min-bp: 'md', $max-bp: 'xl')` → `clamp()`. Below 768px → `$min`. Above 1200px → `$max`. Linear interpolation between. Keep the default `md → xl` window unless there's an explicit reason.

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

**Layout & token rules:**

- Tokens first — reuse `_typography.scss`, `_colors.scss`, `_variables.scss`. Inline raw values only when no token matches; if shared, add a new token instead of inlining.
- Match Figma colors to `_colors.scss` tokens first; raw hex only as fallback.
- **NO flex for gap-only spacing** — only `display: flex` for actual row/column layouts. Vertical spacing between stacked elements: `margin-block-end` on the element.
- Functions: `rem-calc(16)` for fixed equal values, `fluid(min, max)` for responsive ones.
- No stylelint directives.

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

    .tag--primary { /* full modifier class, not &--primary */ }
}
```

**Token quick reference (skip re-reading config files when these match):**

| Category | Values |
|---|---|
| Colors | `$pale #fbf8f3` `$mist #f7f1e8` `$sand #eae2d7` `$muted #8c807d` `$deep #362925` `$primary-color #1f2261` `$secondary-color #fdba00` `$body-color #080c11` |
| Fonts | `$serif-font-family: 'Libre Baskerville'`, `$sans-serif-font-family: 'Geist'` (system stack fallback) |
| Typography | h1:`fluid(32,48)/1.2/-0.96px` h2:`fluid(24,40)/1.4/-0.8px` h3:`fluid(20,32)/1.4/-0.64px` h4:`fluid(18,22)/1.4` h5:`fluid(16,18)/1.4` h6:`fluid(14,16)/1.4` text-small:`fluid(12,14)` text-medium:`fluid(14,16)` |
| Spacing | `$container-padding-x: fluid(20, 40)` |
| Figma tokens | `sp-N` = N px (2,4,6,8,12,16,24,32,48). Radius: `xxs=4 xs=6 sm=8 md=12 lg=16 xl=24` |

### Step 8 — Write JS (only if needed)

Assess from designs + Step 6 markup whether JS is required.

- **Requires JS:** Swiper slider, accordion, tab switching, dialog, counter / scroll animations.
- **Does NOT require JS:** static grids, text/image layouts, pure CSS layouts.

If not needed, **skip the file entirely**. Most blocks have no JS.

If needed, create `blocks/{slug}/{slug}.js`. All JS uses the IIFE pattern. See `.cursor/rules/examples/js-module-template.js` and existing examples (`blocks/testimonials/testimonials.js`, `blocks/faqs/faqs.js`).

**Swiper slider pattern** (copy exactly, adapt options):

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

- Add `min-inline-size: 0` to `.swiper` in SCSS when the slider sits inside a flex/grid parent.
- Swiper navigation classes are always the **standard** ones: `.swiper-navigation`, `.swiper-button-prev`, `.swiper-button-next`. Never block-specific nav classes.

### Step 9 — Wire the block up (the most-forgotten step)

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

### Step 10 — Visual verification (mandatory, three viewports)

After scaffolding + wiring, verify the rendered output matches both Figma designs.

**1. Read `LOCAL_URL`** from project root `.env`. Block renders on the base URL because Step 9 wired it into `index.php`.

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

- **Silence is the default during the work.** No audit trail, no diff table, no narration of what you changed. The user reads the diff themselves.
- **End-of-run report = screenshots + flags.** Show the three screenshots. Add up to 3 bullet flags ONLY if something needs the user's attention: a value you guessed because the design didn't specify it, a button-sizing mismatch you couldn't fix (buttons are owned by `_buttons.scss`), dead/legacy CSS you noticed, a Figma export failure, an unresolved diff after 3 iterations. If the pass was clean, screenshots only — no text.

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
- Other blocks (`blocks/*/`)

**Buttons** — never add or edit `.btn*` rules. Buttons are owned by `_buttons.scss`. No block-scoped `.btn` overrides. Flag button sizing diffs in the report.

**Code style:**

- Logical properties only.
- Images → `assets/images/`, never the block folder.
- `@media` scalar form: `width >= $md`, not `map.get($grid-breakpoints, 'md')`.
- `#{…}` interpolation required inside CSS `min()` / `max()` for Sass compatibility.

## Gotchas

- **Stale class in `blank.php`** — `heading-text-section` is hardcoded; replace with `{slug}-section` immediately during scaffold.
- **Container padding** is site-wide via `$container-padding-x: fluid(20, 40)`. Don't redeclare `padding-inline` on the section to match Figma side-padding — it's already handled.
- **`fluid(0, X)` is BANNED in this skill.** Both designs are available — write real numbers. The `0` placeholder convention belongs to the two-pass workflow (`/acf-block-from-figma` → `/mobile-block`).
- **`fluid(X, X)` is BANNED.** If mobile and desktop values match, collapse to `rem-calc(X)` (or unitless).
- **Dead legacy BEM** — old blocks may still have `.{slug}__button-label` / `__button-icon` selectors. These are dead (current button system is `.btn .btn-icon .btn-dark .btn-md`). New blocks must NOT reintroduce `__` prefixes. Plain child names only.
- **Top-level selectors in `.scss`** — every rule, modifier, and `@media` nests inside `.{slug}-section`. If you find yourself writing a top-level `@media` or utility, you're doing it wrong.
- **`LOCAL_URL`** lives in `.env` — read it, don't assume.
- **`fluid()` scaling window** — default `md → xl` (768 → 1200). Widening the third/fourth args needs explicit user approval.

## Validation Checklist

**Inputs**
- [ ] Both URLs received; mobile first, desktop second
- [ ] Slug determined; `blocks/{slug}/` does not already exist (if it did, user was asked)

**Scaffolding**
- [ ] Block folder created by copying from `blocks/blank/`
- [ ] Stale `heading-text-section` class replaced with `{slug}-section`
- [ ] No `.css` / `.css.map` files copied from blank
- [ ] JS file only exists if the block actually needs JS

**Tokens**
- [ ] `_typography.scss`, `_colors.scss`, `_variables.scss` read before writing SCSS
- [ ] Figma colors matched to existing tokens where possible
- [ ] Typography reuses existing variables/mixins

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

**Markup & A11y**
- [ ] `.container` is the first and only direct child of `.{slug}-section`
- [ ] Semantic HTML; heading hierarchy preserved
- [ ] Informative images have `alt`; decorative have `alt=""`
- [ ] Interactive toggles have `aria-expanded` + `aria-controls`
- [ ] Icon-only buttons have `screen-reader-text`

**Images**
- [ ] Extracted to `assets/images/` at 2x scale (not 1x, not in block folder)

**JS**
- [ ] File only exists if needed; no empty stubs
- [ ] If slider — Swiper init implemented, standard nav classes, `min-inline-size: 0` on `.swiper`

**Wiring**
- [ ] `require` added to root `index.php`
- [ ] CSS `<link>` added to `header.php`
- [ ] JS `<script>` added to `footer.php` (only if JS file exists)
- [ ] Block NOT imported into `src/sass/style.scss`

**Verification**
- [ ] Three screenshots saved: `{slug}-render-375.png`, `{slug}-render-768.png`, `{slug}-render-1440.png`
- [ ] 375 matches mobile Figma, 1440 matches desktop Figma, 768 has no broken state
- [ ] Iterated up to 3 rounds; remaining diffs (if any) reported to the user
