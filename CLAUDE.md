# Skeleton - WordPress Theme

## Overview

Custom WordPress theme built with vanilla JavaScript, SCSS, and PHP following WordPress coding standards and modern best practices.

## Key Principles

1. **Mobile-First Responsive Design** - Always use `media-breakpoint-up()`, never desktop-first
2. **Fluid Typography & Spacing** - Use `fluid()` function, never raw `px` values
3. **No Inline Styles** - All styles in SCSS files
4. **WordPress Coding Standards** - Follow official PHP, JS, and CSS standards
5. **Accessibility First** - WCAG 2.1 AA compliance required

## Design Patterns

**IMPORTANT:** Always reference `.claude/skills/design-patterns.md` for comprehensive patterns.

## Quick Reference

### SCSS
```scss
// ✅ Correct - Mobile-first with fluid values
.component {
  font-size: fluid(16px, 24px);
  padding: fluid(16px, 32px);

  @include media-breakpoint-up(md) {
    // Tablet and up styles
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
// ✅ Correct - WordPress standards
function theme_prefix_function_name() {
    $variable_name = get_option( 'option_name' );
    return esc_html( $variable_name );
}
```

### JavaScript
```javascript
// ✅ Correct - WordPress JS standards
( function() {
    'use strict';

    const initComponent = () => {
        const element = document.querySelector( '.component' );
        if ( ! element ) return;
    };

    document.addEventListener( 'DOMContentLoaded', initComponent );
} )();
```

## Reference Files

- **`.claude/skills/design-patterns.md`** - Complete patterns guide (PRIMARY)
- **`.cursor/rules/`** - Technology-specific standards
- **`AGENTS.md`** - Detailed AI agent guidelines
