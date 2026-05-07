---
name: wp-checklist
description: Runs a sanity checklist on the WordPress theme to catch common mistakes (duplicate ACF field names, stale references, etc.). Invoke explicitly via /wp-checklist.
---

# wp-checklist — WordPress theme sanity checklist

Runs a series of automated checks against the theme. Each check has: what it looks for, how to detect it, and how to fix it. Work through every check in order. Report a single summary at the end listing pass/fail per check and the fix applied (or proposed) for each failure.

## How to use

1. Read this file top-to-bottom.
2. Run each check listed below.
3. For any check that fails, propose the fix and apply it (after confirming with the user if the fix is non-trivial — renames, deletions, multi-file edits).
4. Output a final report:
   ```
   ✓ Check 1: <name>
   ✗ Check 2: <name> — <one-line summary of issue + fix>
   ...
   ```

---

## Check 1 — Global options field names are unique

**What it checks:** Every `name` field across all JSON files in `options/*.json` must be unique. Two ACF option fields with the same `name` cause `get_field('foo', 'option')` to be ambiguous when reading from code (which page does `'foo'` belong to?), making refactors fragile and bugs hard to track down.

**How to detect:**

1. List all files in `options/`.
2. Extract every `"name": "..."` value from each JSON file.
3. Group by name; flag any name that appears in more than one file.

Run this from the theme root to get a fast diff:

```bash
grep -rh '"name":' options/*.json | sort | uniq -d
```

Any line that prints is a duplicate.

**How to fix:**

- Rename the duplicate field `name` in each JSON to a page-scoped name (e.g. `logo` in `header.json` → `header_logo`; `logo` in `footer.json` → `footer_logo`). Keep the `key` as-is — only the `name` needs to change.
- Update **every** `get_field( '<old_name>', 'option' )` call in PHP/JS to use the new name. Search across the whole theme — `header.php`, `footer.php`, `functions/*.php`, block templates — using:
  ```
  grep -rn "get_field(\s*['\"]<old_name>['\"]" .
  ```
- After renaming, re-run the duplicate detection to confirm zero output.
- Note: ACF stores values under each options-page slug, so the database keys won't collide — but the *code-level* ambiguity is what we're fixing. Existing saved values stay intact across the rename because the `key` is unchanged.

**Acceptance:** `grep -rh '"name":' options/*.json | sort | uniq -d` prints nothing.

---

## Check 2 — Textarea fields use the canonical `br + wp_kses_post` pattern

**What it checks:** Every ACF `textarea` field in this theme follows ONE pattern, end-to-end. Picking a single pattern (instead of letting each block choose) means newline handling is predictable across the codebase and editors get richer formatting (inline `<strong>`, `<em>`, `<a>`) without per-block variation.

The canonical pattern, all three parts mandatory:

| Layer | Required | Forbidden |
|---|---|---|
| `{slug}.json` (ACF field) | `"new_lines": "br"` | `""` (raw), `"wpautop"` |
| `{slug}.php` (render) | `wp_kses_post( $value )` | `esc_html( $value )`, `nl2br( … )`, raw `echo` |
| `{slug}.scss` (selector) | (no `white-space` rule) | `white-space: pre-line;` |

Why each rule:

- **`"new_lines": "br"`** — ACF runs `nl2br()` server-side, turning each editor `\n` into a real `<br />` tag. Combined with `wp_kses_post()`, this also lets editors use inline HTML they paste from a rich source (Word, Notion, etc.), which `esc_html()` would visibly escape.
- **`wp_kses_post()`** — required so the `<br />` tags ACF emitted survive escaping. `esc_html()` would render literal `<br />` text on the page.
- **No `white-space: pre-line`** — combining `pre-line` with `new_lines: "br"` causes **double line breaks** (the `<br />` AND the leftover `\n` both render). The CSS rule is correct only for `new_lines: ""`, which we no longer use.

This supersedes the older "use `pre-line`" guidance — `CLAUDE.md` pitfall #4 (no `nl2br()` in PHP) still stands; ACF's server-side `nl2br()` via the `new_lines` config is what we use instead.

**How to detect:**

1. Inventory every textarea field — for each match, record `block`, `field name`, and the JSON's `new_lines` value:
   ```
   grep -rn -B3 '"type": "textarea"' blocks/*/*.json
   grep -rn '"new_lines":' blocks/*/*.json
   ```
2. For each textarea, run **three sub-checks** and report each as PASS/FAIL:

   **2a. JSON `new_lines` value**
   - PASS: value is `"br"`
   - FAIL: value is `""` or `"wpautop"` → fix: edit the field's `new_lines` to `"br"` in `{slug}.json`

   **2b. PHP echo wrapper**
   - Find the render line in `blocks/{slug}/{slug}.php`:
     ```
     grep -n "\$<field_name>\b" blocks/{slug}/{slug}.php
     ```
     Identify the line where the variable is echoed inside markup.
   - PASS: echo uses `wp_kses_post( $<field_name> )`
   - FAIL: echo uses `esc_html( $<field_name> )`, `nl2br( $<field_name> )`, raw `echo $<field_name>`, or any other escape → fix: replace with `wp_kses_post()`
   - SKIP: the field variable is fetched but never echoed (note in report)

   **2c. SCSS `white-space` rule on render target**
   - From step 2b, identify the HTML class on the innermost element wrapping the echo.
   - In `blocks/{slug}/{slug}.scss`, locate that selector inside `.{slug}-section { … }`.
   - PASS: selector has no `white-space: pre-line;` declaration
   - FAIL: selector declares `white-space: pre-line;` → fix: delete that one line

3. Aggregate the failures into a single fix list grouped by file (one section per `.json`, `.php`, `.scss` file) so the edits can be applied in batches.

**How to fix:**

```json
// {slug}.json — change every textarea field
"new_lines": "br"
```

```php
// {slug}.php — render every textarea variable through wp_kses_post
<p class="description"><?php echo wp_kses_post( $description ); ?></p>
```

```scss
// {slug}.scss — remove white-space: pre-line from textarea render-target selectors
.description {
    // delete: white-space: pre-line;
}
```

Never introduce `nl2br()` in PHP — `new_lines: "br"` already does it server-side. Never combine `new_lines: "br"` with `white-space: pre-line` — that's the double-line-break bug.

After editing, re-run all three sub-checks on the affected block to confirm zero failures.

**Acceptance:** Every textarea field across `blocks/*/*.json` has `"new_lines": "br"`; every render site in the matching `{slug}.php` uses `wp_kses_post()`; no `{slug}.scss` selector that targets a textarea echo declares `white-space: pre-line;`.

---

## Check 3 — Block SCSS imports `abstracts-blocks`, not `abstracts`

**What it checks:** Every `blocks/{slug}/{slug}.scss` must `@use` the `abstracts-blocks` partial (which exposes the block-scoped mixins, tokens, and the `fluid()` / `rem-calc()` helpers in their block-friendly form). Importing the bare `abstracts` partial loads a different surface area — the file still compiles, but the wrong tokens load and block-scoped helpers behave inconsistently. There is no compile-time signal; the bug is silent until a designer notices wrong values.

**How to detect:**

```bash
grep -rn "@use '../../src/sass/partials/abstracts'" blocks/*/*.scss
```

Any printed line is a fail. Note the **trailing apostrophe with no `-blocks`** — this rules out `abstracts-blocks` while catching `abstracts` exactly.

**How to fix:**

Replace the offending line with:

```scss
@use '../../src/sass/partials/abstracts-blocks' as *;
```

Do not "match what's already there" — `abstracts-blocks` is always correct in block SCSS. (See `pitfalls.mdc` #8.)

**Acceptance:** `grep -rn "@use '../../src/sass/partials/abstracts'" blocks/*/*.scss` prints nothing.

---

## Check 4 — Block JSON field `key` values are prefixed with `field_{slug}_`

**What it checks:** Every `"key"` in `blocks/{slug}/{slug}.json` (top-level fields **and** repeater/group sub-fields) must start with `field_{slug}_`. ACF stores fields by `key` globally — two blocks defining `field_title` collide and the second-loaded block silently overwrites the first.

**How to detect:**

For each `blocks/{slug}/{slug}.json`:

1. Derive `{slug}` from the directory/filename.
2. Extract every `"key": "..."` value from the JSON.
3. Flag any key that does not start with `field_{slug}_`.

Quick scan to inventory every key/slug pair across all blocks:

```bash
for f in blocks/*/*.json; do slug=$(basename "$(dirname "$f")"); grep -nH '"key":' "$f" | sed "s/^/[$slug] /"; done
```

Any line whose `"key"` does not begin `field_{slug}_` is a fail.

**How to fix:**

Rename the offending `key` to `field_{slug}_{name}` (sub-fields: `field_{slug}_{repeater}_{name}`). Leave the `name` field unchanged — only `key` needs the prefix. After saving, re-import the JSON in ACF (or just re-load the page) so the new keys are persisted. Existing saved values stay intact because ACF keys saved data by post meta key derived from `name`, not `key`.

**Acceptance:** For every block JSON, every `"key"` starts with `field_{slug}_` where `{slug}` matches the parent directory.

---

## Check 5 — Auto-injected developer fields are NOT defined in block JSON

**What it checks:** `register-acf-blocks.php` injects the Settings / Spacing / Display / Custom CSS / Custom Classes / Unique ID fields automatically. If a block's `.json` also defines them, you end up with duplicate fields in the editor (or the auto-injected version overwrites the manual one, or vice versa, depending on registration order). Either way, the editor UI gets ugly and `skel_get_block_developer_options()` may pull the wrong values.

**How to detect:**

```bash
grep -rnE '"name":\s*"(spacing|display|custom_classes|custom_css|unique_id)"' blocks/*/*.json
```

Any printed line is a fail.

**How to fix:**

Delete the offending field object (and any related `tab` field that wraps only these auto-injected fields) from the block JSON. Do not redeclare them anywhere else either — the auto-injection covers every registered block. (See `pitfalls.mdc` #4.)

**Acceptance:** The detection grep prints nothing.

---

## Check 6 — Image fields use `return_format: "id"` and `preview_size: "w200"`

**What it checks:** Every ACF image field in `blocks/*/*.json` must declare `"return_format": "id"` and `"preview_size": "w200"`. The render template assumes an integer ID (`wp_get_attachment_image( $image_id, 'w768', … )`) — if `return_format` is `"array"` or `"url"`, the call silently produces no markup. `preview_size` not being `w200` makes the editor load full-size assets in field previews.

**How to detect:**

For each `blocks/*/*.json` field of `"type": "image"` (top-level **and** repeater/group sub-fields), verify both keys are set:

```bash
grep -rn -B1 -A8 '"type": "image"' blocks/*/*.json | grep -E '"(return_format|preview_size)":'
```

Cross-reference: every image field block should have both `"return_format": "id"` and `"preview_size": "w200"` within its object. Anything else is a fail.

**How to fix:**

Edit the offending field in the JSON:

```json
{
    "key": "field_{slug}_image",
    "label": "Image",
    "name": "image",
    "type": "image",
    "return_format": "id",
    "preview_size": "w200"
}
```

If the field was previously `"return_format": "array"` and PHP code reads `$image['url']`, also fix the PHP to use `wp_get_attachment_image( $image_id, ... )` against the new ID. (See `acf-fields.mdc` and `acf-json-format.mdc`.)

**Acceptance:** Every image field across `blocks/*/*.json` has both `"return_format": "id"` and `"preview_size": "w200"`.

---

## Check 7 — No calls to deprecated `skel_svg(`

**What it checks:** `skel_svg()` was removed; the canonical helper is `skel_get_svg()`. Any remaining `skel_svg(` call is a fatal `Call to undefined function` at runtime. (See `pitfalls.mdc` #6.)

**How to detect:**

```bash
grep -rn "skel_svg(" --include="*.php" .
```

Any line that prints `skel_svg(` and is **not** part of `skel_get_svg(` is a fail. (`grep` will match both; visually filter, or use `grep -rnE '\bskel_svg\(' --include="*.php" .` to anchor on a word boundary so `skel_get_svg(` doesn't match.)

**How to fix:**

Rename to `skel_get_svg(`. The signature is `skel_get_svg( $icon, $attributes = [] )`:

```php
// ❌ deprecated
echo skel_svg( 'arrow-right' );

// ✅
echo skel_get_svg( 'arrow-right', array( 'aria-hidden' => 'true' ) );
```

**Acceptance:** `grep -rnE '\bskel_svg\(' --include="*.php" .` prints nothing.

---

## Check 8 — No top-level `@media` in block SCSS

**What it checks:** Every `@media` block in `blocks/{slug}/{slug}.scss` must be **nested inside** the outer `.{slug}-section { … }` wrapper. A `@media` at column 0 (top-level) escapes the section scope — its rules either leak globally or fail to override the scoped rules they were meant to adjust. (See `pitfalls.mdc` #13.)

**How to detect:**

```bash
grep -rnE '^@media' blocks/*/*.scss
```

Any line that prints is a fail (an `@media` declaration with zero leading whitespace).

**How to fix:**

Move the entire `@media` block inside the section wrapper:

```scss
// ❌ before — top-level @media
.{slug}-section {
    .grid { display: grid; }
}
@media (width >= $md) {
    .{slug}-section .grid { grid-template-columns: repeat(3, 1fr); }
}

// ✅ after — nested
.{slug}-section {
    .grid {
        display: grid;
        @media (width >= $md) {
            grid-template-columns: repeat(3, 1fr);
        }
    }
}
```

**Acceptance:** `grep -rnE '^@media' blocks/*/*.scss` prints nothing.

---

## Check 9 — No BEM `&__` / `&--` shorthand in block SCSS

**What it checks:** This project does not use BEM. Block SCSS uses **plain child class names nested inside `.{slug}-section`** — uniqueness comes from nesting, not naming. The SCSS `&` parent selector with `__` or `--` produces names like `.home-hero__title` / `.home-hero--dark` that the project's markup never uses, so the rules have no effect. Modifiers are written in full (e.g. `.tag--dark`), never via `&--`. (See `pitfalls.mdc` #1.)

**How to detect:**

```bash
grep -rnE '&__|&--' blocks/*/*.scss
```

Any line that prints is a fail.

**How to fix:**

Rewrite the selector in full:

```scss
// ❌
.home-hero {
    &__title { … }
    &__cta { … }
    .tag {
        &--dark { … }
    }
}

// ✅ — nested inside the section wrapper, plain child names; modifier in full
.home-hero-section {
    .title { … }
    .cta { … }
    .tag--dark { … }
}
```

**Acceptance:** `grep -rnE '&__|&--' blocks/*/*.scss` prints nothing.

---

## Check 10 — Block SCSS root selector matches `.{slug}-section`

**What it checks:** Every block's SCSS file should have exactly one outer wrapper selector and it should equal `.{slug}-section`, where `{slug}` is the parent directory name. A mismatch (usually a copy-paste from another block) means the block's styles either don't apply at all or apply to the wrong block on pages where both are present.

**How to detect:**

For each `blocks/{slug}/{slug}.scss`:

1. Derive `{slug}` from the directory name.
2. Find the first non-comment, non-`@use`, non-`@forward` line that declares a selector (i.e. ends with `{` or contains `,`).
3. PASS if that line's selector is `.{slug}-section`. FAIL otherwise.

Quick inventory:

```bash
for f in blocks/*/*.scss; do slug=$(basename "$(dirname "$f")"); first=$(grep -nE '^\.[a-z0-9-]+' "$f" | head -1); echo "[$slug] $first"; done
```

Any line whose first selector does not match `.{slug}-section` (for that `{slug}`) is a fail.

**How to fix:**

Rename the wrapper selector to match the directory:

```scss
// blocks/home-hero/home-hero.scss
// ❌
.hero-section { … }
// ✅
.home-hero-section { … }
```

Also confirm the block's `.php` template uses the same class on its root `<section>`.

**Acceptance:** Every `blocks/{slug}/{slug}.scss` has `.{slug}-section { … }` as its outermost selector.

---

## Check 11 — No `@include font(...)` or `@include text(...)` in block SCSS

**What it checks:** The project uses inline `fluid()` typography — every block declares its own `font-size` / `line-height` / `font-family` with `fluid(min, max)` and config tokens. The legacy `@include font(...)` and `@include text(...)` mixins emit static values that bypass the responsive scale; they're forbidden in block SCSS. (See `pitfalls.mdc` #15.)

**How to detect:**

```bash
grep -rnE '@include\s+(font|text)\(' blocks/*/*.scss
```

Any printed line is a fail.

**How to fix:**

Replace the mixin call with inline declarations using `fluid()` and the config tokens (`$serif`, `$sans-serif`, `$body-font-size`, etc. from `_typography.scss`):

```scss
// ❌
.title { @include font(h2); }
.caption { @include text(small); }

// ✅
.title   { font-family: $serif; font-size: fluid(24, 40); line-height: 1.2; }
.caption { font-size: fluid(12, 14); }
```

For headings, prefer adding the matching `.h1`–`.h6` class to the markup and overriding only the diff in SCSS (see `scss-standards.mdc` → "Headings"). Never re-add `@include font/text` even if the existing block uses it — fix it.

**Acceptance:** `grep -rnE '@include\s+(font|text)\(' blocks/*/*.scss` prints nothing.

---

## Check 12 — No desktop-first or raw-px `@media` in block SCSS

**What it checks:** All block media queries must be **mobile-first** (`@media (width >= $bp)`) and reference a **named breakpoint variable** from `_breakpoints.scss` (`$xs`, `$ph`, `$sm`, `$md`, `$lg`, `$xl`, `$xxl`, `$xxxl`). Forbidden:

- Desktop-first range syntax: `@media (width < $bp)`
- Legacy syntax: `@media (min-width: …)` or `@media (max-width: …)`
- Raw px values in queries: `@media (width >= 900px)`

Mixing desktop-first and mobile-first in the same codebase silently flips override precedence; raw px sidesteps the centralized breakpoint scale and drifts from design. (See `scss-standards.mdc` and `pitfalls.mdc` #10.)

**How to detect:**

Run all three:

```bash
# desktop-first (forbidden)
grep -rnE '@media\s*\(\s*width\s*<' blocks/*/*.scss

# legacy min-width / max-width (forbidden)
grep -rnE '@media\s*\((min|max)-width' blocks/*/*.scss

# raw-px width queries (forbidden — must use a $bp variable)
grep -rnE '@media[^{]*[0-9]+px' blocks/*/*.scss
```

Any printed line from any of the three is a fail.

**How to fix:**

Rewrite as mobile-first using a named breakpoint variable:

```scss
// ❌ desktop-first
@media (width < $md) { grid-template-columns: 1fr; }

// ❌ legacy
@media (max-width: 767px) { grid-template-columns: 1fr; }

// ❌ raw px
@media (width >= 900px) { grid-template-columns: repeat(3, 1fr); }

// ✅ mobile-first, named variable — invert the layout so mobile is the default
.grid {
    grid-template-columns: 1fr;
    @media (width >= $md) {
        grid-template-columns: repeat(3, 1fr);
    }
}
```

If the only thing changing at a breakpoint is a *value* (font-size, padding, gap), drop the `@media` entirely and use `fluid(min, max)` instead — `@media` is for layout shape changes only.

**Acceptance:** All three detection greps print nothing.

---

## Adding new checks

Append new checks below as new `## Check N — <name>` sections, each with the same three subsections (**What it checks**, **How to detect**, **How to fix**) and an explicit **Acceptance** line. Keep checks deterministic — a check should either pass or fail based on grep/file inspection, not on judgment.
