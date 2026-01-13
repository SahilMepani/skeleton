# Skeleton Theme

WordPress theme with ACF blocks.

## Commands
```bash
npm run dev    # Dev + BrowserSync
npm run build  # Production
```

## Critical Rules

### SCSS
```scss
// ❌ font-size: 18px; @media (min-width: 768px) {}
// ✅
gap: rem-calc(16);  font-size: fluid(16, 24);  @media (width >= $md) {}
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
	if (!el) return;  // No spaces in parens
	el.addEventListener('click', handleClick);
})();
```

## Core Rules
- No inline styles, jQuery, !important
- `js-*` prefix for JS classes
- Escape output, sanitize input
- Tabs for indentation

## Standards
Auto-load from `.cursor/rules/`: scss, php, javascript, accessibility, project-patterns
