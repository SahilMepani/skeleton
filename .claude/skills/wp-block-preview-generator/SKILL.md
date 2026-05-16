---
name: wp-block-preview-generator
description: Walks every page of a running web app and saves one screenshot per unique repeated section/component (e.g. ACF blocks, design-system sections, route-level views) to a per-component folder. Use when the user asks for component/block/section preview thumbnails, design-system snapshots, or asks to "regenerate previews" for blocks. Invoke explicitly via /wp-block-preview-generator.
disable-model-invocation: true
allowed-tools: Bash(playwright-cli:*), Read, Write, Edit, Glob, Grep
---

# wp-block-preview-generator — Component preview screenshot generator

Drives a running dev site with `playwright-cli`, walks every page reachable from a navigation menu (or a user-supplied URL list), identifies repeated section/component wrappers, and saves one screenshot per unique component to a per-component folder. Skips components that already have a preview file, and dedupes across pages so the same component isn't captured twice.

The skill is project-agnostic: configuration is gathered from the user up front, then a single Playwright script runs the capture loop.

---

## When to use

- "Generate preview images for all blocks/sections/components."
- "Take a screenshot of every section on every page and save it under each block folder as preview.png."
- "Refresh the design-system thumbnails."
- "Build a visual index of components."

If the user just wants a single page screenshot, use the regular `playwright-cli` skill instead.

---

## Required inputs

Before running, gather these from the user (use `AskUserQuestion` for any not provided). Pick sensible defaults from the project structure when possible — don't ask if you can derive it.

| Input | Default / how to derive | Example |
| --- | --- | --- |
| **Base URL** | `http://localhost:3000/` if reachable, else ask | `http://localhost:8080/` |
| **Pages to visit** | Auto-discover from `header nav a, .menu a` on the base URL | List of absolute URLs |
| **Section selector** | `section[class*="-section"]` if WP/ACF blocks; otherwise ask | `[data-component]`, `.block`, etc. |
| **Slug extraction rule** | Strip `-section` suffix from the matching class. For `[data-component="foo"]`, use the attribute value | `home-hero-section` → `home-hero` |
| **Output path template** | `blocks/{slug}/preview.png` if a `blocks/` folder exists; otherwise ask | `src/components/{slug}/preview.png` |
| **Viewport** | `1440 × 900` desktop unless the user specifies | `1280 × 800`, `375 × 812` mobile |
| **Max height cap** | `900` (viewport height). Anything taller is clipped to the top portion | `1200` |
| **Skip-if-exists** | `true` (skip when output file already present) | toggle |

---

## Workflow

### Step 1 — Confirm dev server is running

```bash
playwright-cli open <BASE_URL>
```

If the page errors or the title is wrong, stop and tell the user. Do **not** start `npm start` yourself — assume it's already running.

### Step 2 — Auto-discover pages (if not provided)

```bash
playwright-cli eval "() => Array.from(document.querySelectorAll('header nav a, .menu a, .main-menu a')).map(a => ({text: a.textContent.trim(), href: a.href})).filter(a => a.href.startsWith(location.origin))"
```

Show the discovered list to the user and confirm before proceeding. Add any missing pages they call out (often: pages with no menu link, like `/search/` or `/404/`).

### Step 3 — Inventory existing previews

Use `Glob` to list all `{output_path_pattern}` files that already exist. These slugs go into the **skip set**. (Per the user's `Skip-if-exists` choice.)

Use `Glob` to list all candidate slug folders (the parent folder for each output path), so the script knows the valid slug whitelist. This avoids capturing stray `*-section` matches that don't correspond to a real component folder.

### Step 4 — Run the capture script

Write the script in `references/capture.js` (see below) into a temp file at the project root, e.g. `.preview-capture.js`. Embed:
- Pre-computed `allSlugs` array (valid component folders).
- Pre-computed `existing` Set (slugs that already have a preview file).
- The full `urls` array.
- The output path template, viewport, max height, and section selector.

Run via:

```bash
playwright-cli run-code "$(cat .preview-capture.js)"
```

**Why a temp file?** The `run-code` evaluator runs in a sandboxed Node context — `require('fs')` and `require('path')` are **not available**. All filesystem facts must be embedded as constants up front.

### Step 5 — Verify

After the run prints its summary:

1. `Read` 2–3 of the new PNGs into the conversation to spot-check framing.
2. Show the user three lists: **Captured**, **Skipped (already had preview)**, **Never seen** (slugs in the folder list that didn't appear on any page).
3. For "Never seen" slugs, ask whether they should be captured from a specific page — they may be admin-only, search-only, or 404-only.

### Step 6 — Clean up

Delete the temp `.preview-capture.js`. Close the browser:

```bash
playwright-cli close
```

---

## Sizing rules

- **Width:** the viewport width. Full-bleed sections render at the viewport width naturally; narrower wrappers will be captured at their actual rendered width via element screenshot.
- **Height:** `min(sectionHeight, maxHeight)`.
  - If `sectionHeight ≤ maxHeight`: use `locator.screenshot({ path })` — captures the element at its natural height.
  - If `sectionHeight > maxHeight`: scroll the section's top edge to viewport y=0 and use `page.screenshot({ clip: { x, y, width, height: maxHeight } })`.

This guarantees every preview is the same width and never taller than the viewport, while preserving short sections at their natural height (no awkward whitespace below).

---

## Lazy-load handling

Sections often use `loading="lazy"` images and Swiper carousels that initialise on scroll. Before each screenshot:

1. `locator.scrollIntoViewIfNeeded()` — triggers any IntersectionObserver-based loaders.
2. `await page.waitForTimeout(600)` — give Swiper a beat to lay out.
3. Wait for every `<img>` inside the section to be `complete`, with a 2.5s per-image cap.

Without this you'll capture skeletons and broken Swiper layouts.

---

## Capture script template

The full reference implementation lives at `references/capture.js`. The shape is:

```js
async (page) => {
	const OUTPUT_TEMPLATE = '<absolute-path>/{slug}/preview.png';
	const VIEWPORT = { width: 1440, height: 900 };
	const MAX_HEIGHT = 900;
	const SECTION_SELECTOR = 'section[class*="-section"]';
	const SLUG_FROM_CLASS = (el) => {
		const cls = el.className.split(/\s+/).find(c => /-section$/.test(c) && c !== 'section');
		return cls ? cls.replace(/-section$/, '') : null;
	};
	const allSlugs = [/* embedded folder list */];
	const existing = new Set([/* embedded preview-already-exists list */]);
	const urls = [/* embedded URL list */];

	// ... (see references/capture.js for the full loop)
}
```

When customising for a different project:
- Swap `SECTION_SELECTOR` (e.g. `'[data-component]'`).
- Swap `SLUG_FROM_CLASS` (e.g. `el => el.dataset.component`).
- Update `OUTPUT_TEMPLATE` to match the project's component folder layout.

---

## Common pitfalls

1. **`require is not defined`** — `run-code` is sandboxed; embed all filesystem-derived data as constants. Don't try `require('fs')` inside the script.
2. **Trailing semicolon after the arrow function literal** — `playwright-cli run-code` parses the argument as a function expression. Ending the file with `};` causes `Unexpected token ';'`. End with `}` only.
3. **Backslashes in Windows paths** — use forward slashes in `OUTPUT_TEMPLATE`. Playwright accepts them on Windows; backslashes in JS string literals get interpreted as escapes.
4. **First occurrence wins** — when the same component appears on multiple pages with different content (e.g. a `page-banner` on every interior page), the script only captures it once. Tell the user this up front; if they want per-page variants, they need a different naming scheme (`{slug}-{page}.png`).
5. **Headers/footers** — global chrome usually shouldn't be captured per-component. By default, restrict the section selector to the page's main content area (e.g. `main section[class*="-section"]`) if header/footer also use the same wrapper class.
6. **Scroll-stuck sticky elements** — sticky headers will appear at the top of clipped screenshots. If the project uses one, either toggle it off via CSS injection (`document.querySelector('.site-header').style.position = 'static'`) before screenshot, or accept it.
