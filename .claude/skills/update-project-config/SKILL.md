---
name: update-project-config
description: Re-syncs project-specific blocks in .cursor/rules/*.mdc and .cursor/AGENTS.md from the codebase's actual source of truth (SCSS config partials, helper PHP, style.css header). Run after any change to theme tokens, helpers, prefix, or text domain. Invoke explicitly via /update-project-config.
---

# update-project-config — sync `.cursor` docs from the codebase

The `.cursor/rules/*.mdc` and `.cursor/AGENTS.md` files mix two kinds of content:

1. **Methodology / patterns** that are theme-agnostic (mobile-first `@media`, `fluid()` vs `@media`, ACF field conventions, etc.).
2. **This theme's concrete values** — colors, fonts, breakpoints, helper signatures, text domain, PHP prefix, file paths.

The codebase already holds the source of truth for #2 (SCSS config partials, helper PHP files, `style.css` header). This skill regenerates the project-specific blocks in the `.cursor` docs from those source files, so the rules stay accurate without manual editing.

## How to use

1. Read this file top-to-bottom.
2. Run the **bootstrap check** below. On the first ever run there are no markers in the `.cursor` files; you must add them once, interactively, before any sync can happen.
3. Walk through each step in order. For each step: READ the source file → EXTRACT values → REWRITE the content between the matching `<!-- @project-config:* -->` markers in the target `.mdc` file.
4. Show a per-file diff summary to the user and confirm before saving non-trivial rewrites. Trivial rewrites (the markers' content is byte-identical to the regenerated content) are skipped silently.
5. Output the final report (format at the bottom of this file).
6. After the report, invoke `/init` (via the Skill tool with `skill: "init"`) to refresh `CLAUDE.md` so its codebase documentation reflects the just-synced `.cursor` rules.

Do not edit text outside the markers. Do not invent values. If a source file does not exist, or a value cannot be extracted unambiguously, surface the problem in the report — do not guess.

## Bootstrap (one-time)

The first time this skill runs, the `.cursor` files have no markers around their project-specific blocks. Detect this with:

```
grep -rln '@project-config:' .cursor/
```

If it prints nothing, you are bootstrapping. Do this:

1. For each target file/section listed in the **Marker map** below, find the existing prose block that corresponds to it and propose wrapping it in markers:

   ```
   <!-- @project-config:<section-id> -->
   ...current content...
   <!-- @end -->
   ```

2. Show the user the full list of proposed markers (file path + section id + first/last line of the block being wrapped). Ask for confirmation before writing.

3. After confirmation, insert the markers. Do **not** regenerate values yet — bootstrap only adds wrappers.

4. Then continue with the sync steps below.

If markers already exist (the grep printed lines), skip bootstrap and go straight to syncing.

## Marker map

Every project-specific block has a stable section id. The skill rewrites only the content between matching `<!-- @project-config:<id> -->` and `<!-- @end -->`.

| Section id | File | What lives here |
|---|---|---|
| `identity` | `.cursor/AGENTS.md` | Text domain, PHP prefix, indent style |
| `npm-scripts` | `.cursor/AGENTS.md` | `npm start`, `npm run build` (and any sibling) |
| `colors` | `.cursor/rules/theme-config.mdc` | Color palette + semantic + typography colors |
| `fonts` | `.cursor/rules/theme-config.mdc` | Font-family vars, body/heading defaults |
| `heading-scale` | `.cursor/rules/theme-config.mdc` | h1–h6 + display scale |
| `breakpoints` | `.cursor/rules/theme-config.mdc` | Breakpoint variables and px values |
| `container` | `.cursor/rules/theme-config.mdc` | Container max-widths + padding |
| `spacing` | `.cursor/rules/theme-config.mdc` | `.spacing-{top,bottom}-{small,medium,large,xlarge}` values |
| `php-constants` | `.cursor/rules/theme-config.mdc` | `DEFAULT_THUMBNAIL_ID`, `PAGE_404_ID`, `PAGE_SEARCH_ID`, etc. |
| `colors-tokens` | `.cursor/rules/scss-standards.mdc` | The `_colors.scss` variable list inside "Config tokens" |
| `typography-tokens` | `.cursor/rules/scss-standards.mdc` | The `_typography.scss` variable list + mixin names |
| `breakpoint-tokens` | `.cursor/rules/scss-standards.mdc` | Breakpoint variable names + path |
| `variables-tokens` | `.cursor/rules/scss-standards.mdc` | The `_variables.scss` variable list |
| `legacy-partials` | `.cursor/rules/scss-standards.mdc` | Specific paths in the "Legacy exception" paragraph |
| `helpers-table` | `.cursor/rules/helpers-reference.mdc` | Full table of every public helper |
| `folder-tree` | `.cursor/rules/project-structure.mdc` | The theme's folder tree |
| `image-sizes` | `.cursor/rules/acf-fields.mdc` | Registered image sizes (`w200`, `w480`, …) |
| `auto-injected-fields` | `.cursor/rules/pitfalls.mdc` and `.cursor/rules/acf-json-format.mdc` | List of fields auto-injected by `register-acf-blocks.php` |
| `gulp-tasks` | `.cursor/rules/build-workflow.mdc` | Gulp task names and `package.json` scripts |
| `block-section-naming` | `.cursor/rules/project-patterns.mdc` | `.{slug}-section` convention reference |
| `prefix-references` | `.cursor/rules/php-standards.mdc`, `wordpress-standards.mdc` | Inline `'skel'` / `skel_` mentions in examples |

If a section in the map is missing in the actual file, skip it and note "section not present" in the report — don't fabricate a section.

## Step 1 — Identity tokens

**Read from:**
- `style.css` header → `Text Domain:` line
- Most common `function {prefix}_*` prefix across `functions/**/*.php` (use the one that occurs most often; if there's a tie, list both and ask the user)
- `.editorconfig` at the theme root → `indent_style` (tab vs space)

**Update marker:** `identity` in `.cursor/AGENTS.md`.

**Render template (example shape — match the existing AGENTS.md style):**
```
- Text Domain: `'<domain>'`
- PHP Prefix: `<prefix>_`
- Indent: <Tabs|Spaces>
```

## Step 2 — npm scripts

**Read from:** `package.json` → `scripts` object.

**Update marker:** `npm-scripts` in `.cursor/AGENTS.md`. List every script as a one-liner: `npm run <name>` followed by the command (or a short description if the command is long).

## Step 3 — Colors

**Read from:** `src/sass/partials/config/_colors.scss`. Parse every top-level `$name: <value>;` declaration. Group into:
- **Palette** — vars whose value is a hex/rgb/hsl literal AND whose name is NOT a `*-color` semantic name (e.g. `$pale`, `$mist`, `$sand`, `$muted`, `$deep`)
- **Semantic** — `$primary-color`, `$secondary-color`, `$success-color`, `$info-color`, `$warning-color` (any var matching `*-color` that isn't a typography target)
- **Typography** — `$body-color`, `$heading-color`, `$link-color`, `$link-hover-color`

If a var doesn't fit cleanly, list it under whichever group its comment / position in the file suggests; otherwise put it in "Other" and flag for manual review.

**Update markers:**
- `colors` in `theme-config.mdc` — full table with values
- `colors-tokens` in `scss-standards.mdc` — variable name list only (no values), grouped the same way

## Step 4 — Typography

**Read from:** `src/sass/partials/config/_typography.scss`. Extract:
- Font-family vars (`$serif`, `$sans-serif`, `$body-font-family`, `$heading-font-family`, …) and their values
- Numeric defaults (`$body-font-size`, `$paragraph-line-height`, `$paragraph-margin-block-end`, `$heading-margin-block-end`)
- The `$typography-styles` map (h1–h6 entries — capture each heading's `font-size` value)
- Any display-scale map (`$display-styles` or similar — `display-1`, `display-2`, …)
- Mixin names defined in this file (`@mixin font(...)`, `@mixin text(...)`)

**Update markers:**
- `fonts` in `theme-config.mdc` — font-family vars + body defaults
- `heading-scale` in `theme-config.mdc` — h1–h6 + display table
- `typography-tokens` in `scss-standards.mdc` — variable + mixin name list

## Step 5 — Breakpoints

**Read from:** `src/sass/partials/config/_breakpoints.scss`. Parse every `$<name>: <px>;` and produce the ordered list (preserve declaration order).

**Update markers:**
- `breakpoints` in `theme-config.mdc` — full var/value list
- `breakpoint-tokens` in `scss-standards.mdc` — variable name list (e.g. `$xs`, `$ph`, `$sm`, `$md`, `$lg`, `$xl`, `$xxl`, `$xxxl`) plus the path `src/sass/partials/config/_breakpoints.scss`

## Step 6 — Other variables

**Read from:** `src/sass/partials/config/_variables.scss`. Group into:
- Container (`$container-padding-x`, `$container-max-width-*`, …)
- Menu (`$menu-breakpoint`, …)
- Easing (`$custom-ease`, …)
- Z-index (`$z-*`)
- Selection / scrollbar tokens
- Other

**Update marker:** `variables-tokens` in `scss-standards.mdc` — grouped variable list.

## Step 7 — Container / spacing

**Read from:** the partial(s) under `src/sass/partials/` that define `.container` and `.spacing-{top,bottom}-{small,medium,large,xlarge}`. Find them with:

```
grep -rn '\.container\b' src/sass/partials/
grep -rn '\.spacing-\(top\|bottom\)-' src/sass/partials/
```

Extract per-breakpoint container max-widths and the spacing `fluid(min, max)` values for each size.

**Update markers:**
- `container` in `theme-config.mdc`
- `spacing` in `theme-config.mdc`

## Step 8 — PHP constants

**Read from:** any PHP file under `functions/` or the theme root. Find with:

```
grep -rn "define( '\(DEFAULT_THUMBNAIL_ID\|PAGE_404_ID\|PAGE_SEARCH_ID\)" .
```

(Plus any other top-level `define( '...' …)` that looks like a theme-level config constant.)

**Update marker:** `php-constants` in `theme-config.mdc`.

## Step 9 — Helper functions

**Read from:** every `functions/**/*.php` that contains `function {prefix}_`. Primary files in this theme:
- `functions/core/helpers.php`
- `functions/core/svg-helpers.php`
- `functions/blocks-system/acf-block-helpers.php`
- (plus anything else surfaced by `grep -rln 'function skel_' functions/`)

For each public helper (top-level `function`, not method, not `_internal_*`), extract:
- Signature: function name + parameter list (with default values)
- Description: the first non-empty line of the docblock summary directly above the function

If a helper has no docblock, list it with description `(no docblock)` and note in the report so the user can add one.

**Update marker:** `helpers-table` in `helpers-reference.mdc`. Regenerate the entire table — preserve the file's intro/outro prose (which lives outside the markers).

Group helpers by source file with a sub-heading per file, then list each helper as:

```
### `skel_function_name( $arg1, $arg2 = default )`

One-line description from the docblock summary.
```

## Step 10 — Image sizes

**Read from:** `functions/core/add-image-sizes.php` (or wherever `add_image_size(` is called — confirm with `grep -rn 'add_image_size' --include='*.php' .`).

For each call, capture: size name, width, height, crop flag.

**Update marker:** `image-sizes` in `acf-fields.mdc`. List as a table.

## Step 11 — Auto-injected developer fields

**Read from:** `functions/blocks-system/register-acf-blocks.php`. Find the array / loop that injects developer fields (Settings, Spacing, Display, Custom CSS, Custom Classes, Unique ID). Extract the canonical list of field `name` values.

**Update markers:**
- `auto-injected-fields` in `acf-fields.mdc`
- `auto-injected-fields` in `pitfalls.mdc` (same content, both files)

## Step 12 — Project structure

**Read from:** the actual top-level directory tree (depth 2 is enough for the docs):

```
ls -la
ls blocks/
ls src/
ls src/sass/partials/
ls functions/
```

**Update marker:** `folder-tree` in `project-structure.mdc`. Render as a tree listing matching the file's existing format. Skip `node_modules`, `.git`, `vendor`, build output (`build/`, `dist/`).

## Step 13 — Gulp tasks + npm scripts

**Read from:** `gulpfile.mjs` (top-level `task(...)` / `export const ...` declarations) and `package.json` `scripts`.

**Update marker:** `gulp-tasks` in `build-workflow.mdc`. List each script and what it does (use the npm script command or the Gulp task name as the key).

## Step 14 — Block-section naming

**Read from:** sample two or three `blocks/{slug}/{slug}.scss` files and confirm the convention: outer wrapper is `.{slug}-section`. If the project has changed the convention, surface it.

**Update markers:**
- `block-section-naming` in `swiper-standards.mdc`
- `block-section-naming` in `project-patterns.mdc`
- `block-section-naming` in `pitfalls.mdc`

The text in each file is short (one or two sentences referencing the convention). Update only those references.

## Step 15 — Prefix references in identity-affected rule files

**Read from:** the identity tokens already extracted in Step 1 (`{domain}`, `{prefix}`).

**Update marker:** `prefix-references` in:
- `php-standards.mdc`
- `wordpress-standards.mdc`
- `accessibility.mdc`
- `acf-json-format.mdc`

Each file has a small block (one or two examples) that mentions the text domain or PHP prefix. Replace just those occurrences inside the marker. Do not touch unrelated examples.

## Output report

End the run with a single block in this format:

```
update-project-config — synced from codebase

Bootstrap: <skipped | applied (markers added to N files)>

Files updated:
  ✓ AGENTS.md          — domain='<domain>', prefix='<prefix>_'
  ✓ theme-config.mdc   — colors (X added, Y removed, Z re-valued), fonts <unchanged|updated>, breakpoints <…>
  ✓ scss-standards.mdc — _colors.scss tokens regenerated
  ✓ helpers-reference.mdc — N helpers (added: …, removed: …)
  …

Files unchanged:
  – <file>.mdc

Issues / manual review:
  – <description of anything that couldn't be resolved automatically>
```

If there are issues, list them concretely (file + line + what was unclear) so the user can fix the source and rerun.

## Final step — refresh CLAUDE.md

After printing the report, invoke the `init` skill (via the Skill tool: `skill: "init"`) so `CLAUDE.md` is regenerated against the just-synced `.cursor` rules. This is mandatory unless the report's "Files updated" list is empty AND bootstrap was skipped — in that case nothing changed, so skip `/init` and note "init skipped — no changes" in the report.

## Rules

- Never edit text outside the markers.
- Never invent values. If a source file is missing or unparseable, report it and skip that section.
- Never run on `.cursor` files that have markers from a different version of this skill (different section id naming) — surface the conflict and stop.
- The skill is invoked manually only. Do not register hooks. Do not auto-run after file edits.
- Do not commit changes. The user reviews the diff and commits separately.
