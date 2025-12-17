# Skeleton - WordPress Theme

## Overview

Custom WordPress theme built with vanilla JavaScript, SCSS, and PHP following WordPress coding standards. Uses ACF blocks for content editing.

## Key Principles

1. **Mobile-First Responsive Design** - Always use `@include media-breakpoint-up()`, never desktop-first
2. **Fluid Typography & Spacing** - Use `fluid()` for responsive values, `rem-calc()` for fixed values
3. **No Inline Styles** - All styles in SCSS files under `src/sass/partials/`
4. **WordPress Coding Standards** - Follow official PHP standards with `skel_` prefix
5. **Accessibility First** - WCAG 2.1 AA compliance required

## Quick Reference

### SCSS

```scss
// ✅ Correct - Mobile-first with fluid/rem-calc values
.component {
	font-size: fluid(16, 24);
	padding: fluid(16, 32);
	gap: rem-calc(16);

	@include media-breakpoint-up(md) {
		// Tablet and up styles
	}

	@include media-breakpoint-up(lg) {
		// Desktop and up styles
	}
}

// ❌ Wrong - Desktop-first with px values
.component {
	font-size: 24px;
	@media (max-width: 768px) {
		font-size: 16px;
	}
}
```

### PHP

```php
// ✅ Correct - WordPress standards with skel_ prefix
function skel_function_name() {
	$variable_name = get_option( 'option_name' );
	return esc_html( $variable_name );
}

// Text domain is 'skel'
esc_html_e( 'Text', 'skel' );
```

### JavaScript

```javascript
// ✅ Correct - Arrow function IIFE pattern
(() => {
	const element = document.querySelector('.element');
	if (!element) return;

	element.addEventListener('click', e => {
		e.preventDefault();
		// Handle click
	});
})();
```

## Project Structure

```
skeleton/
├── acf-blocks/           # ACF block templates
├── functions/            # PHP function files (skel_ prefix)
├── src/
│   ├── js/
│   │   ├── custom/       # Custom JS files
│   │   └── plugins/      # Third-party plugins
│   └── sass/
│       ├── partials/
│       │   ├── config/   # Variables, colors, maps
│       │   ├── mixins/   # Breakpoints, rem-calc, fluid
│       │   ├── components/
│       │   ├── acf-blocks/
│       │   └── ...
│       └── style.scss
├── template-parts/
├── js/                   # Compiled JS
├── style.css             # Compiled CSS
└── functions.php
```

## Reference Files

- **`AGENTS.md`** - Detailed AI agent guidelines (PRIMARY)
- **`.claude/skills/design-patterns.md`** - Complete patterns guide
- **`.cursor/rules/`** - Technology-specific standards
- **`README - Copy.md`** - Setup and formatting guide
