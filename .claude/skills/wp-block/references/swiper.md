# Swiper wiring (read only when Step 3 wired Swiper)

Step 3 already decided whether Swiper runs at all sizes or only below `$md`. This file covers the JSON / SCSS / PHP markup / JS init that follows from that decision.

## JSON (in `{slug}.json`)

Add `"needs_swiper": true`. This is read by `functions/blocks-system/register-acf-blocks.php`, which enqueues the `skel-swiper` asset bundle on the front end when the block is present.

## SCSS (in `{slug}.scss`)

- `.{block}-slider { inline-size: 100%; min-inline-size: 0; overflow: visible; }` — `min-inline-size: 0` is the standard Swiper-inside-flexbox fix; `overflow: visible` lets adjacent slides peek past the container edge.
- Slide widths: `inline-size: rem-calc(X); max-inline-size: 90%;` — **not** `flex: 0 0 rem-calc(X)`. Swiper's wrapper is already a flex container; the `flex` shorthand fights its internal sizing.
- No `overflow-x: auto` on the wrapper — Swiper owns overflow.
- `#{…}` Sass interpolation required inside CSS `min()` / `max()`.

## PHP markup (in `{slug}.php`)

Wrap items in `.{block}-slider.swiper > .swiper-wrapper > .swiper-slide`. Per-item content lives inside each `.swiper-slide`. Don't put `data-inview` / `data-aos` on `.swiper-slide` itself — put them on the content element inside the slide (e.g. the `.card` or article inside). If another block in this project already uses Swiper, read it as a structural reference (read-only).

## JS (in `{slug}.js`)

Follow `.cursor/rules/swiper-standards.mdc` §2 — scoped navigation/pagination wiring, single-slide bailout, `slidesPerView: 'auto'` + `spaceBetween` for variable-width slides.

Destroy logic from Step 3:

- **Mobile slider + desktop static** → `matchMedia('(min-width: ${$md}px)')` listener; instantiate below `$md`, destroy at/above. Re-instantiate when the viewport shrinks back below `$md`.
- **Slider at all sizes** → no destroy logic; just initialize on `DOMContentLoaded`.

JS rules: no `var`, `const` default, tabs, camelCase, no spaces inside JS parentheses. JS-only DOM hooks use `js-*` prefix.
