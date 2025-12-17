# Skeleton - WordPress Theme

A modern WordPress theme built with vanilla JavaScript, SCSS, and PHP following WordPress coding standards and best practices.

## Key Principles

1. **Mobile-First Responsive Design** - Always use `media-breakpoint-up()`, never desktop-first
2. **Fluid Typography & Spacing** - Use `fluid()` function, never raw `px` values
3. **No Inline Styles** - All styles in SCSS files
4. **WordPress Coding Standards** - Follow official PHP, JS, and CSS standards
5. **Accessibility First** - WCAG 2.1 AA compliance required

## Quick Start

1. Copy theme to `wp-content/themes/skeleton`
2. Install SCSS compiler (node-sass, dart-sass, etc.)
3. Compile SCSS: `sass assets/scss/style.scss assets/css/main.css`
4. Activate theme in WordPress admin

## Critical Rules

### SCSS - Always Use:
```scss
// ✅ Fluid values
font-size: fluid(16px, 24px);
padding: fluid(20px, 40px);

// ✅ Mobile-first breakpoints
@include media-breakpoint-up(md) { }
@include media-breakpoint-up(lg) { }
```

### SCSS - Never Use:
```scss
// ❌ Raw px values
font-size: 18px;

// ❌ Direct @media
@media (min-width: 768px) { }

// ❌ Desktop-first
@include media-breakpoint-down(md) { }
```

## File Structure

```
skeleton/
├── assets/
│   ├── scss/
│   │   ├── abstracts/      # Variables, functions, mixins
│   │   ├── base/           # Reset, typography
│   │   ├── components/     # Buttons, cards, forms
│   │   ├── layout/         # Header, footer, grid
│   │   └── style.scss      # Main entry point
│   ├── js/
│   └── css/
├── inc/                    # PHP includes
├── template-parts/         # Template partials
├── .cursor/rules/          # AI coding rules
├── .claude/skills/         # AI design patterns
├── functions.php
└── style.css
```

## AI Assistant Configuration

This theme includes configuration files for AI coding assistants:

### `.cursor/rules/` (Cursor IDE Rules)
- `wordpress-standards.mdc` - Always applied WordPress rules
- `scss-standards.mdc` - SCSS conventions
- `php-standards.mdc` - PHP/WordPress standards
- `javascript-standards.mdc` - JS conventions
- `accessibility.mdc` - Accessibility requirements

### `.claude/skills/` (Design Patterns)
- `design-patterns.md` - Comprehensive patterns guide

## Development

### Compile SCSS
```bash
# Watch mode
sass --watch assets/scss:assets/css

# Production (compressed)
sass assets/scss/style.scss assets/css/main.css --style=compressed
```

### WordPress Coding Standards
```bash
# Install PHP_CodeSniffer
composer require --dev squizlabs/php_codesniffer wp-coding-standards/wpcs

# Check PHP files
phpcs --standard=WordPress .
```

## Resources

- [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- [WordPress Theme Handbook](https://developer.wordpress.org/themes/)
- [WCAG 2.1 Guidelines](https://www.w3.org/WAI/WCAG21/quickref/)
