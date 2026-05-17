## Token-Saving Rules

- `npm start` is already running — never compile manually, never run sass/gulp/build commands unless explicitly asked.
- Block starter files (`.php`, `.scss`, `.js`, `.json`) and config entry already exist when user asks to implement — never generate blank files or update `config.php`
- Prefer updating source files only; let the watcher handle generated assets.
- Edit tool struggles with tab-indented files — use Write for full rewrites
- Never re-read a file you just wrote — trust your own output.
- Never commit or run git commands unless explicitly asked.
- Use the Write tool (full file) instead of Read+Edit for new files.
- Skip plan mode for standard blocks.
- Keep responses short — no explanations unless asked, no improvements beyond what was requested.

# Skeleton Theme

<!-- @project-config:identity -->

**Domain**: `'skel'` | **Prefix**: `skel_` | **Indent**: Tabs

<!-- @end -->

WordPress theme with ACF blocks.

# AI Coding Guidelines

You are acting as a WordPress expert developer AI assistant on this project.

**CRITICAL: Your very first step for any prompt MUST be to identify and load relevant rules and skills.**

1. **Locate Rules & Skills:** Use your file reading / directory listing tools to check the contents of:
    - `.cursor/commands/`
    - `.cursor/rules/`
    - `.claude/skills/`
2. **Review & Apply:** Open and read any files from these directories that seem relevant to the user's request BEFORE generating code.
3. **Claude Skills:** When a task matches a Claude skill (inside `.claude/skills/`), read its `SKILL.md` file directly. Treat these skills as executable instructions.

## Reference

Read files in `.cursor/rules/` **only when needed for the specific task**:

| File                       | Contents                                                                          |
| -------------------------- | --------------------------------------------------------------------------------- |
| `project-patterns.mdc`     | Block structure, data attributes (incl. animation attrs), helpers, image/swiper patterns |
| `php-standards.mdc`        | PHP naming, formatting, escaping, heading markup                                  |
| `scss-standards.mdc`       | SCSS functions, breakpoints, responsive rules, typography pattern, logical properties |
| `javascript-standards.mdc` | IIFE pattern, JS rules                                                            |
| `acf-fields.mdc`           | ACF field types, PHP access patterns, image sizes, repeater normalization         |
| `acf-json-format.mdc`      | How to write block `.json` field files                                            |
| `image-assets.mdc`         | Image asset location, Figma export, ACF image render (`wp_get_attachment_image`), `img-cover` / `img-link` |
| `snippets.mdc`             | Block boilerplate, repeater, WP query, swiper, accordion, dialog                  |
| `helpers-reference.mdc`    | Full helper function signatures with examples                                     |
| `theme-config.mdc`         | Colors, typography, spacing values, breakpoints                                   |
| `build-workflow.mdc`       | Gulp tasks, npm commands, compilation                                             |
| `project-structure.mdc`    | Full folder layout                                                                |
| `wordpress-standards.mdc`  | Template hierarchy, hooks                                                         |
| `accessibility.mdc`        | WCAG, focus, ARIA patterns                                                        |
| `pitfalls.mdc`             | Known pitfalls and antipatterns (incl. no `.btn*` edits, container padding, `!important`, inline styles) |
| `swiper-standards.mdc`     | Swiper HTML/JS/SCSS, navigation, responsive destroy/init                          |
| `scroll-performance.mdc`   | 60-FPS scroll rules, offscreen pause, will-change discipline                      |
| `skip-scss-linting.mdc`    | Skip Stylelint and SCSS auto-fixes                                                |
| `examples/`                | Full block PHP, SCSS, JS templates                                                |

## Commands

<!-- @project-config:npm-scripts -->

```bash
npm start          # Watch mode (dev build + BrowserSync)
npm run build      # Production build (NODE_ENV=production)
```

<!-- @end -->

## Critical Rules

### SCSS

```scss
// ❌ font-size: 18px; @media (min-width: 768px) {}
// ✅
gap: rem-calc(16);
font-size: fluid(16, 24);
@media (width >= $md) {
}
```

### PHP

```php
function skel_function_name() { }  // Prefix: skel_ | Domain: 'skel'
echo esc_html( $text );            // Always escape
if ( $condition ) { }              // Spaces in parens
```

### JavaScript

```javascript
(() => {
	const el = document.querySelector('.el');
	if (!el) return; // No spaces in parens
	el.addEventListener('click', handleClick);
})();
```

## Core Rules

- No inline styles, jQuery, !important
- `js-*` prefix for JS classes
- Escape output, sanitize input
- Tabs for indentation

## Standards

Load the relevant rule on demand from `.cursor/rules/`: `php-standards`, `scss-standards`, `javascript-standards`, `wordpress-standards`, `acf-fields`, `acf-json-format`, `project-patterns`, `project-structure`, `build-workflow`, `theme-config`, `helpers-reference`, `snippets`, `swiper-standards`, `accessibility`, `pitfalls`, `scroll-performance`, `skip-scss-linting`. `image-assets`.

For scroll/animation perf work: capture a Chrome DevTools trace (4× CPU, Slow 4G, Screenshots ON) before changing code. Apply only fixes the trace justifies.
