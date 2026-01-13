# Skeleton Theme

Custom WordPress theme with ACF blocks.

## Quick Start

```bash
npm run dev        # Development with BrowserSync
npm run build      # Production build
npm run lint:js    # ESLint
npm run lint:css   # Stylelint
```

## Critical Rules

### SCSS

```scss
// ❌ NEVER
font-size: 18px;
@media (min-width: 768px) {
}

// ✅ ALWAYS
gap: rem-calc(16);
font-size: fluid(16, 24);
@media (width >= $md) {
}
```

### PHP

```php
// Prefix: skel_ | Text domain: 'skel'
function skel_function_name() { }
__( 'Text', 'skel' );

// Always escape/sanitize
echo esc_html( $text );
$clean = sanitize_text_field( $_POST['field'] );

// Spaces inside parentheses
if ( $condition ) { }
```

### JavaScript

```javascript
// Arrow function IIFE (no spaces in parentheses)
(() => {
	const element = document.querySelector('.element');
	if (!element) return;
	element.addEventListener('click', handleClick);
})();
```

## Core Principles

- Never use inline styles
- Never use jQuery
- Never use !important
- Use `js-*` prefix for JS-controlled classes
- Escape all PHP output / Sanitize all input
- Tabs for indentation (not spaces)

## Detailed Standards

File-type-specific rules auto-load from `.cursor/rules/`:

- `scss-standards.mdc` - SCSS patterns & functions
- `php-standards.mdc` - PHP/WordPress conventions
- `javascript-standards.mdc` - JavaScript patterns
- `accessibility.mdc` - WCAG 2.1 AA compliance
- `project-patterns.mdc` - ACF blocks, helpers (always loaded)
