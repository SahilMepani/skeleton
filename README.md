# Skeleton - WordPress Theme

A responsive custom WordPress theme built with vanilla JavaScript, SCSS, and PHP.

## Initial Setup

1. [Download WordPress](https://wordpress.org/latest.zip) and install it on your local server
2. [Download the Theme](https://github.com/SahilMepani/skeleton/archive/refs/heads/blocks.zip) and move it inside `wp-content/themes/`
3. Run `node -v` to check if you have Node installed. If not, [Download Node](https://nodejs.org/en/)
4. Install packages and start watching:

```powershell
cd /path/to/your/wp-content/themes/skeleton
npm i --force
npm start
```

If you get "grunt is not recognized" error:

```powershell
npm i -g grunt-cli
# restart terminal
npm start
```

## Theme Activation

1. Rename the theme folder to match your project name
2. Create `screenshot.png` [600x600]px at the root
3. Create `favicon.png` and `favicon.ico` at the root
4. Update theme name and details in `src/sass/style.scss`
5. Run `npm start` and activate the theme

---

## SCSS Rules

### Never Use Raw px Values

```scss
// ❌ NEVER
.component {
	font-size: 18px;
	padding: 24px;
}

// ✅ Use rem-calc() for fixed values
.component {
	gap: rem-calc(16);
	border-radius: rem-calc(8);
}

// ✅ Use fluid() for responsive values
.component {
	font-size: fluid(16, 18);
	padding: fluid(16, 24);
}
```

### Always Use Mobile-First Breakpoints

```scss
// ❌ NEVER
@media (min-width: 768px) {
}
@include media-breakpoint-down(md) {
}

// ✅ ALWAYS
@include media-breakpoint-up(md) {
}
@include media-breakpoint-up(lg) {
}
```

---

## JavaScript

All JS files are in `/src/js/plugins` and `/src/js/custom` folders and compile to `/js/plugins.js` and `/js/custom.js`.

- **Plugin Code** - Create files in `/src/js/plugins`
- **Custom Code** - Create files in `/src/js/custom`

Files automatically compile - no manual imports needed.

---

## HTML - Class/ID Naming

**All classes and IDs should be lowercase and separated by a dash.**

Full-width sections use the `section` tag with `-section` suffix:

```html
<section class="hero-slider-section">
	<div class="container"></div>
</section>
```

- Classes/IDs targeted by JavaScript should use `js-` prefix (e.g., `js-active`)
- Avoid ID selectors for styling

---

## Animation Data Attributes

### data-inview / data-aos

| Attribute               | Description                                                                 |
| ----------------------- | --------------------------------------------------------------------------- |
| `data-inview`           | Element observed for viewport entry. Sets `data-inview="true"` when visible |
| `data-inview-repeat`    | Removes attribute when element exits viewport                               |
| `data-inview-offset`    | Offset for when element is considered in view (px or %)                     |
| `data-inview-threshold` | Proportion visible before triggering. Default: `0.05` (5%)                  |
| `data-aos`              | Animation type (e.g., `fade-up`). Runs when `data-inview="true"`            |
| `data-aos-stagger-item` | Staggered animations among child elements                                   |

### CSS Custom Properties

```scss
--aos-duration: 1000ms;
--aos-delay: 0ms;
--aos-stagger-interval: 100ms;
--aos-distance: 40px;
```

---

## Toggle Data Attributes

| Attribute           | Description                                          |
| ------------------- | ---------------------------------------------------- |
| `data-toggle-click` | Toggles `js-active` class when clicked               |
| `data-toggle-group` | Groups elements - only one has `js-active` at a time |
| `data-toggle-link`  | Links elements to toggle `js-active` together        |
| `data-toggle-hover` | Toggles `js-active` on hover                         |

### Usage Examples

```html
<!-- Click toggle with group -->
<div data-toggle-click="example" data-toggle-group="group1"></div>

<!-- Linked elements -->
<div data-toggle-click="example"></div>
<div data-toggle-link="example"></div>

<!-- Hover toggle -->
<div data-toggle-hover="example"></div>
<div data-toggle-link="example"></div>
```

---

## File Structure

```
skeleton/
├── acf-blocks/           # ACF block templates
├── functions/            # PHP function files
├── src/
│   ├── js/
│   │   ├── custom/       # Custom JS files
│   │   └── plugins/      # Third-party plugins
│   └── sass/
│       ├── partials/
│       │   ├── config/   # colors, maps, variables
│       │   ├── mixins/   # breakpoints, rem-calc, fluid
│       │   ├── components/
│       │   └── acf-blocks/
│       └── style.scss
├── js/                   # Compiled JS
├── template-parts/
├── functions.php
└── style.css             # Compiled CSS
```

---

## AI Rules

Configuration files for AI coding assistants:

- `.cursor/rules/` - Cursor IDE rules (SCSS, JS, PHP, accessibility)
- `.claude/skills/design-patterns.md` - Comprehensive patterns guide
- `AGENTS.md` - AI agent guidelines

---

## Resources

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
