# Design Patterns - Skeleton WordPress Theme

This document captures the established design patterns, conventions, and best practices for the Skeleton WordPress theme.

## Table of Contents
1. [Critical Rules](#critical-rules)
2. [SCSS Patterns](#scss-patterns)
3. [PHP Patterns](#php-patterns)
4. [JavaScript Patterns](#javascript-patterns)
5. [Component Architecture](#component-architecture)
6. [Accessibility Standards](#accessibility-standards)
7. [File Organization](#file-organization)

---

## Critical Rules

### NEVER Violate These Rules

#### 1. No Inline Styles
```php
// ❌ NEVER
<div style="color: red; padding: 20px;">

// ✅ ALWAYS use classes
<div class="component component--highlighted">
```

#### 2. No Raw px Values in SCSS
```scss
// ❌ NEVER
.component {
  font-size: 18px;
  padding: 24px;
  margin-bottom: 32px;
}

// ✅ ALWAYS use fluid()
.component {
  font-size: fluid(16px, 18px);
  padding: fluid(16px, 24px);
  margin-bottom: fluid(24px, 32px);
}
```

**Exceptions where px is allowed:**
- `1px` borders
- Box shadows
- Border radius (if design requires it)

#### 3. No @media Breakpoints Directly
```scss
// ❌ NEVER
@media (min-width: 768px) { }
@media (max-width: 768px) { }
@media screen and (min-width: 992px) { }

// ✅ ALWAYS use media-breakpoint-up()
@include media-breakpoint-up(md) { }
@include media-breakpoint-up(lg) { }
```

#### 4. No Desktop-First / media-breakpoint-down
```scss
// ❌ NEVER - Desktop-first
.component {
  font-size: fluid(24px, 32px);
  grid-template-columns: repeat(3, 1fr);

  @include media-breakpoint-down(md) {
    font-size: fluid(16px, 20px);
    grid-template-columns: 1fr;
  }
}

// ✅ ALWAYS mobile-first
.component {
  font-size: fluid(16px, 20px);
  grid-template-columns: 1fr;

  @include media-breakpoint-up(lg) {
    font-size: fluid(24px, 32px);
    grid-template-columns: repeat(3, 1fr);
  }
}
```

---

## SCSS Patterns

### The fluid() Function

**Purpose:** Generate responsive `clamp()` values for fluid typography and spacing.

```scss
// Basic usage: fluid(min-size, max-size)
font-size: fluid(16px, 24px);
padding: fluid(20px, 40px);
margin-bottom: fluid(32px, 64px);
gap: fluid(16px, 32px);

// With custom viewport range
font-size: fluid(16px, 24px, 320px, 1400px);
```

**Implementation:**
```scss
// In abstracts/_functions.scss
@function strip-unit($number) {
  @if type-of($number) == 'number' and not unitless($number) {
    @return $number / ($number * 0 + 1);
  }
  @return $number;
}

@function fluid($min, $max, $min-vw: 320px, $max-vw: 1200px) {
  $min-val: strip-unit($min);
  $max-val: strip-unit($max);
  $min-vw-val: strip-unit($min-vw);
  $max-vw-val: strip-unit($max-vw);

  $slope: ($max-val - $min-val) / ($max-vw-val - $min-vw-val);
  $y-intercept: $min-val - ($slope * $min-vw-val);

  $min-rem: ($min-val / 16) * 1rem;
  $max-rem: ($max-val / 16) * 1rem;
  $preferred: ($y-intercept / 16) * 1rem + ($slope * 100vw);

  @return clamp(#{$min-rem}, #{$preferred}, #{$max-rem});
}
```

### Breakpoint System (Mobile-First ONLY)

```scss
// In abstracts/_variables.scss
$breakpoints: (
  sm: 576px,
  md: 768px,
  lg: 992px,
  xl: 1200px,
  xxl: 1400px
);

// In abstracts/_mixins.scss
@mixin media-breakpoint-up($breakpoint) {
  $value: map-get($breakpoints, $breakpoint);
  @if $value {
    @media (min-width: $value) {
      @content;
    }
  } @else {
    @warn "Breakpoint `#{$breakpoint}` not found.";
  }
}

// ⚠️ DO NOT CREATE media-breakpoint-down mixin
```

**Usage Pattern:**
```scss
.component {
  // Mobile styles (default)
  display: flex;
  flex-direction: column;
  padding: fluid(16px, 20px);

  @include media-breakpoint-up(md) {
    // Tablet and up (768px+)
    flex-direction: row;
    padding: fluid(20px, 32px);
  }

  @include media-breakpoint-up(lg) {
    // Desktop and up (992px+)
    padding: fluid(32px, 48px);
  }

  @include media-breakpoint-up(xl) {
    // Large desktop and up (1200px+)
  }
}
```

### BEM Naming Convention

```scss
// Block
.card {
  background: $color-surface;
}

// Element
.card__header {
  padding: fluid(16px, 24px);
}

.card__body {
  padding: fluid(20px, 32px);
}

.card__footer {
  border-top: 1px solid $color-border;
}

// Modifier
.card--featured {
  border: 2px solid $color-accent;
}

.card--compact {
  .card__body {
    padding: fluid(12px, 16px);
  }
}

// Element with modifier
.card__header--large {
  font-size: fluid(20px, 28px);
}
```

### CSS Variables Pattern

```scss
// Global variables in :root
:root {
  --color-primary: #{$color-primary};
  --color-secondary: #{$color-secondary};
  --color-accent: #{$color-accent};
  --color-text: #{$color-text};
  --color-background: #{$color-background};

  --font-family-base: #{$font-family-base};
  --font-family-heading: #{$font-family-heading};

  --spacing-sm: #{fluid(8px, 12px)};
  --spacing-md: #{fluid(16px, 24px)};
  --spacing-lg: #{fluid(32px, 48px)};
  --spacing-xl: #{fluid(48px, 80px)};
}

// Component-scoped variables
.card {
  --card-padding: #{fluid(16px, 24px)};
  --card-border-color: var(--color-border);

  padding: var(--card-padding);
  border: 1px solid var(--card-border-color);
}
```

### Grid Layout Pattern
```scss
.grid {
  display: grid;
  gap: fluid(16px, 32px);
  grid-template-columns: 1fr;

  @include media-breakpoint-up(md) {
    grid-template-columns: repeat(2, 1fr);
  }

  @include media-breakpoint-up(lg) {
    grid-template-columns: repeat(3, 1fr);
  }

  @include media-breakpoint-up(xl) {
    grid-template-columns: repeat(4, 1fr);
  }
}
```

### Flexbox Pattern
```scss
.flex-container {
  display: flex;
  flex-direction: column;
  gap: fluid(12px, 16px);

  @include media-breakpoint-up(md) {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
  }
}
```

---

## PHP Patterns

### Function Naming
```php
// Always prefix with theme name
function skeleton_get_custom_logo() { }
function skeleton_register_sidebars() { }
function skeleton_enqueue_scripts() { }
```

### Escaping Output (ALWAYS)
```php
// Text content
echo esc_html( $text );

// HTML attributes
<div class="<?php echo esc_attr( $class ); ?>">

// URLs
<a href="<?php echo esc_url( $url ); ?>">

// HTML content (allows safe tags)
echo wp_kses_post( $html_content );

// Translation with escaping
echo esc_html__( 'Text', 'skeleton' );
esc_html_e( 'Text', 'skeleton' );
```

### Sanitizing Input (ALWAYS)
```php
$clean_text = sanitize_text_field( $_POST['field'] );
$clean_email = sanitize_email( $_POST['email'] );
$clean_url = esc_url_raw( $_POST['url'] );
$clean_int = absint( $_GET['id'] );
```

### Template Parts
```php
// Load template part
get_template_part( 'template-parts/content', get_post_type() );

// With arguments (WordPress 5.5+)
get_template_part( 'template-parts/card', 'product', array(
    'product_id' => $product_id,
    'show_price' => true,
) );

// In template part
$product_id = $args['product_id'] ?? 0;
$show_price = $args['show_price'] ?? false;
```

### The Loop
```php
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <?php the_title( '<h2 class="entry-title">', '</h2>' ); ?>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>

    <?php the_posts_pagination(); ?>
<?php else : ?>
    <p><?php esc_html_e( 'No posts found.', 'skeleton' ); ?></p>
<?php endif; ?>
```

### Hooks Pattern
```php
// Actions
add_action( 'after_setup_theme', 'skeleton_setup' );
add_action( 'wp_enqueue_scripts', 'skeleton_enqueue_scripts' );
add_action( 'widgets_init', 'skeleton_register_sidebars' );

// Filters
add_filter( 'body_class', 'skeleton_body_classes' );
add_filter( 'excerpt_length', 'skeleton_excerpt_length' );
```

---

## JavaScript Patterns

### IIFE Pattern (Required)
```javascript
( function() {
    'use strict';

    const init = () => {
        // Initialize components
    };

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
} )();
```

### Spacing Rules
```javascript
// Spaces inside parentheses
if ( condition ) { }
for ( let i = 0; i < 10; i++ ) { }
document.querySelector( '.selector' );
functionName( arg1, arg2 );

// Arrays and objects
const array = [ 1, 2, 3 ];
const object = { key: 'value' };
```

### Event Handling
```javascript
const handleClick = ( event ) => {
    event.preventDefault();
    const target = event.currentTarget;
    // Handle click
};

element.addEventListener( 'click', handleClick );

// Event delegation
document.addEventListener( 'click', ( event ) => {
    const button = event.target.closest( '.js-button' );
    if ( ! button ) return;

    handleButtonClick( button );
} );
```

### Async/Await
```javascript
const fetchData = async ( url ) => {
    try {
        const response = await fetch( url );

        if ( ! response.ok ) {
            throw new Error( `HTTP error! status: ${response.status}` );
        }

        return await response.json();
    } catch ( error ) {
        console.error( 'Fetch error:', error );
        return null;
    }
};
```

### WordPress AJAX
```javascript
const submitForm = async ( formData ) => {
    try {
        const response = await fetch( skeletonData.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            body: new URLSearchParams( {
                action: 'skeleton_submit_form',
                nonce: skeletonData.nonce,
                ...Object.fromEntries( formData ),
            } ),
        } );

        const data = await response.json();

        if ( ! data.success ) {
            throw new Error( data.data.message || 'Unknown error' );
        }

        return data.data;
    } catch ( error ) {
        console.error( 'AJAX error:', error );
        throw error;
    }
};
```

---

## Component Architecture

### Component Structure (PHP)
```php
<section class="component" id="component-<?php echo esc_attr( $unique_id ); ?>">
    <div class="component__wrapper">
        <?php if ( $title ) : ?>
            <h2 class="component__title">
                <?php echo esc_html( $title ); ?>
            </h2>
        <?php endif; ?>

        <div class="component__content">
            <?php echo wp_kses_post( $content ); ?>
        </div>

        <?php if ( $items ) : ?>
            <div class="component__grid">
                <?php foreach ( $items as $item ) : ?>
                    <div class="component__item">
                        <?php echo esc_html( $item['name'] ); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
```

### Component SCSS
```scss
.component {
  padding-block: fluid(40px, 80px);
  background-color: var(--color-background);
}

.component__wrapper {
  max-width: var(--container-width);
  margin-inline: auto;
  padding-inline: fluid(16px, 24px);
}

.component__title {
  font-size: fluid(24px, 40px);
  font-family: var(--font-family-heading);
  margin-bottom: fluid(24px, 40px);
  text-align: center;
}

.component__content {
  font-size: fluid(16px, 18px);
  line-height: 1.6;
  max-width: 65ch;
  margin-inline: auto;
}

.component__grid {
  display: grid;
  gap: fluid(16px, 32px);
  grid-template-columns: 1fr;
  margin-top: fluid(32px, 48px);

  @include media-breakpoint-up(md) {
    grid-template-columns: repeat(2, 1fr);
  }

  @include media-breakpoint-up(lg) {
    grid-template-columns: repeat(3, 1fr);
  }
}

.component__item {
  padding: fluid(16px, 24px);
  background: var(--color-surface);
}
```

---

## Accessibility Standards

### Focus Indicators
```scss
.button,
.link,
input,
select,
textarea {
  &:focus-visible {
    outline: 2px solid var(--color-focus);
    outline-offset: 2px;
  }
}
```

### Reduced Motion
```scss
@media (prefers-reduced-motion: reduce) {
  *,
  *::before,
  *::after {
    animation-duration: 0.01ms !important;
    animation-iteration-count: 1 !important;
    transition-duration: 0.01ms !important;
  }
}
```

### Screen Reader Text
```scss
.screen-reader-text {
  position: absolute;
  width: 1px;
  height: 1px;
  padding: 0;
  margin: -1px;
  overflow: hidden;
  clip: rect(0, 0, 0, 0);
  white-space: nowrap;
  border: 0;

  &:focus {
    position: fixed;
    top: fluid(8px, 12px);
    left: fluid(8px, 12px);
    z-index: 100000;
    width: auto;
    height: auto;
    padding: fluid(12px, 16px) fluid(20px, 24px);
    clip: auto;
    background: var(--color-background);
    color: var(--color-text);
  }
}
```

### Form Accessibility
```php
<label for="email-field">
    <?php esc_html_e( 'Email Address', 'skeleton' ); ?>
    <span class="required" aria-hidden="true">*</span>
</label>
<input
    type="email"
    id="email-field"
    name="email"
    required
    aria-required="true"
    aria-describedby="email-description"
>
<p id="email-description" class="field-description">
    <?php esc_html_e( 'We will never share your email.', 'skeleton' ); ?>
</p>
```

---

## File Organization

### Theme Structure
```
skeleton/
├── assets/
│   ├── scss/
│   │   ├── abstracts/
│   │   │   ├── _variables.scss
│   │   │   ├── _functions.scss
│   │   │   └── _mixins.scss
│   │   ├── base/
│   │   │   ├── _reset.scss
│   │   │   └── _typography.scss
│   │   ├── components/
│   │   ├── layout/
│   │   └── style.scss
│   ├── js/
│   │   └── main.js
│   └── css/
├── inc/
│   ├── setup.php
│   ├── enqueue.php
│   ├── template-functions.php
│   └── template-tags.php
├── template-parts/
│   └── content/
├── functions.php
├── style.css
├── index.php
├── header.php
├── footer.php
├── single.php
├── page.php
├── archive.php
├── search.php
└── 404.php
```

### SCSS Import Order
```scss
// style.scss

// 1. Abstracts (no CSS output)
@import 'abstracts/variables';
@import 'abstracts/functions';
@import 'abstracts/mixins';

// 2. Vendors
@import 'vendors/normalize';

// 3. Base
@import 'base/reset';
@import 'base/typography';

// 4. Layout
@import 'layout/header';
@import 'layout/footer';
@import 'layout/grid';

// 5. Components
@import 'components/buttons';
@import 'components/cards';
@import 'components/forms';

// 6. Pages (if needed)
@import 'pages/home';

// 7. Utilities (last)
@import 'base/utilities';
```

---

## Quick Reference

### SCSS Cheat Sheet
```scss
// Fluid values
font-size: fluid(16px, 24px);
padding: fluid(20px, 40px);
gap: fluid(16px, 32px);

// Breakpoints (mobile-first ONLY)
@include media-breakpoint-up(sm) { }  // 576px+
@include media-breakpoint-up(md) { }  // 768px+
@include media-breakpoint-up(lg) { }  // 992px+
@include media-breakpoint-up(xl) { }  // 1200px+
@include media-breakpoint-up(xxl) { } // 1400px+
```

### PHP Cheat Sheet
```php
// Escape output
esc_html( $text )
esc_attr( $attr )
esc_url( $url )
wp_kses_post( $html )

// Translate
__( 'Text', 'skeleton' )
esc_html__( 'Text', 'skeleton' )
esc_html_e( 'Text', 'skeleton' )

// Sanitize input
sanitize_text_field( $input )
sanitize_email( $email )
absint( $number )
```

### JavaScript Cheat Sheet
```javascript
// Spacing
if ( condition ) { }
document.querySelector( '.class' );
functionName( arg );

// Variables
const element = document.querySelector( '.el' );
let counter = 0;

// IIFE wrapper
( function() { 'use strict'; /* code */ } )();
```
