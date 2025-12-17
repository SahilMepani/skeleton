# AI Agent Guidelines for Skeleton WordPress Theme

## Project Structure

```
theme-name/
├── assets/
│   ├── scss/
│   │   ├── abstracts/
│   │   │   ├── _variables.scss
│   │   │   ├── _mixins.scss
│   │   │   └── _functions.scss
│   │   ├── base/
│   │   ├── components/
│   │   ├── layout/
│   │   └── style.scss
│   ├── js/
│   └── images/
├── inc/
│   ├── setup.php
│   ├── enqueue.php
│   └── template-functions.php
├── template-parts/
├── functions.php
├── style.css
└── index.php
```

## Critical Rules - NEVER Violate

### 1. Never Use Inline Styles
```php
// ❌ NEVER do this
<div style="color: red; padding: 20px;">

// ✅ Always use classes
<div class="component component--highlighted">
```

### 2. Never Use Raw px Values in SCSS
```scss
// ❌ NEVER do this
.component {
  font-size: 18px;
  padding: 24px;
  margin-bottom: 32px;
}

// ✅ Always use fluid()
.component {
  font-size: fluid(16px, 18px);
  padding: fluid(16px, 24px);
  margin-bottom: fluid(24px, 32px);
}
```

### 3. Never Use @media Breakpoints Directly
```scss
// ❌ NEVER do this
@media (min-width: 768px) { }
@media (max-width: 768px) { }
@media screen and (min-width: 992px) { }

// ✅ Always use media-breakpoint-up()
@include media-breakpoint-up(md) { }
@include media-breakpoint-up(lg) { }
@include media-breakpoint-up(xl) { }
```

### 4. Never Use Desktop-First / media-breakpoint-down
```scss
// ❌ NEVER do this - Desktop-first approach
.component {
  font-size: fluid(24px, 32px);

  @include media-breakpoint-down(md) {
    font-size: fluid(16px, 20px);
  }
}

// ✅ Always mobile-first with media-breakpoint-up
.component {
  font-size: fluid(16px, 20px);

  @include media-breakpoint-up(lg) {
    font-size: fluid(24px, 32px);
  }
}
```

## SCSS Standards

### The fluid() Function
```scss
// fluid(min-size, max-size, min-viewport, max-viewport)
// Generates clamp() with calculated values

.heading {
  font-size: fluid(24px, 48px);        // Default viewport range
  font-size: fluid(24px, 48px, 320px, 1200px); // Custom range
}
```

### Breakpoint System
```scss
// Available breakpoints (mobile-first only)
@include media-breakpoint-up(sm) { }  // 576px and up
@include media-breakpoint-up(md) { }  // 768px and up
@include media-breakpoint-up(lg) { }  // 992px and up
@include media-breakpoint-up(xl) { }  // 1200px and up
@include media-breakpoint-up(xxl) { } // 1400px and up
```

### BEM Naming Convention
```scss
// Block
.card { }

// Element
.card__header { }
.card__body { }
.card__footer { }

// Modifier
.card--featured { }
.card--compact { }

// Element with modifier
.card__header--large { }
```

### SCSS File Organization
```scss
// abstracts/_variables.scss
$color-primary: #1a1a2e;
$color-secondary: #16213e;
$color-accent: #e94560;

$font-family-base: 'Inter', sans-serif;
$font-family-heading: 'Poppins', sans-serif;

$breakpoints: (
  sm: 576px,
  md: 768px,
  lg: 992px,
  xl: 1200px,
  xxl: 1400px
);

// abstracts/_functions.scss
@function fluid($min, $max, $min-vw: 320px, $max-vw: 1200px) {
  $min-rem: #{$min / 16px}rem;
  $max-rem: #{$max / 16px}rem;
  $slope: ($max - $min) / ($max-vw - $min-vw);
  $y-intercept: $min - ($slope * $min-vw);
  $preferred: #{$y-intercept / 16px}rem + #{$slope * 100}vw;

  @return clamp(#{$min-rem}, #{$preferred}, #{$max-rem});
}

// abstracts/_mixins.scss
@mixin media-breakpoint-up($breakpoint) {
  $value: map-get($breakpoints, $breakpoint);
  @if $value {
    @media (min-width: $value) {
      @content;
    }
  }
}
```

## PHP Standards (WordPress)

### Naming Conventions
```php
// Functions: lowercase with underscores, prefixed
function skeleton_get_custom_logo() { }
function skeleton_register_sidebars() { }

// Classes: Capitalized words
class Skeleton_Custom_Walker { }
class Skeleton_Theme_Setup { }

// Constants: Uppercase with underscores
define( 'SKELETON_VERSION', '1.0.0' );
define( 'SKELETON_DIR', get_template_directory() );

// Variables: lowercase with underscores
$post_id = get_the_ID();
$custom_field = get_post_meta( $post_id, '_custom_field', true );
```

### Spacing & Formatting
```php
// Spaces inside parentheses
if ( $condition ) { }
foreach ( $items as $item ) { }
function_call( $arg1, $arg2 );

// Spaces around operators
$result = $a + $b;
$is_valid = $value === true;

// Array syntax
$array = array(
    'key1' => 'value1',
    'key2' => 'value2',
);

// Short array syntax (PHP 5.4+)
$array = [
    'key1' => 'value1',
    'key2' => 'value2',
];
```

### Escaping & Sanitization
```php
// Always escape output
echo esc_html( $text );
echo esc_attr( $attribute );
echo esc_url( $url );
echo wp_kses_post( $html_content );

// Always sanitize input
$clean_text = sanitize_text_field( $_POST['field'] );
$clean_email = sanitize_email( $_POST['email'] );
$clean_int = absint( $_GET['id'] );
```

### Template Tags
```php
// Correct WordPress template structure
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <article <?php post_class(); ?>>
            <h2><?php the_title(); ?></h2>
            <?php the_content(); ?>
        </article>
    <?php endwhile; ?>
<?php else : ?>
    <p><?php esc_html_e( 'No posts found.', 'skeleton' ); ?></p>
<?php endif; ?>
```

## JavaScript Standards (WordPress)

### IIFE Pattern
```javascript
( function() {
    'use strict';

    // All code here
} )();
```

### Spacing Rules
```javascript
// Spaces inside parentheses for control structures
if ( condition ) { }
for ( let i = 0; i < 10; i++ ) { }
while ( condition ) { }

// Spaces inside function calls
functionName( arg1, arg2 );
document.querySelector( '.selector' );

// Spaces around operators
const result = a + b;
const isValid = value === true;
```

### DOM Ready Pattern
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

### Event Handling
```javascript
const handleClick = ( event ) => {
    event.preventDefault();
    const target = event.currentTarget;
    // Handle click
};

element.addEventListener( 'click', handleClick );
```

## Accessibility Standards

### Semantic HTML
```php
<header class="site-header">
    <nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'skeleton' ); ?>">
    </nav>
</header>

<main id="main-content">
    <article>
        <h1><?php the_title(); ?></h1>
    </article>
</main>

<footer class="site-footer">
</footer>
```

### Skip Links
```php
<a class="skip-link screen-reader-text" href="#main-content">
    <?php esc_html_e( 'Skip to content', 'skeleton' ); ?>
</a>
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

## Common Mistakes to Avoid

### SCSS
- ❌ Using raw `px` values
- ❌ Using `@media` queries directly
- ❌ Using `media-breakpoint-down()`
- ❌ Desktop-first approach
- ❌ Deep nesting (more than 3 levels)
- ❌ Using IDs for styling

### PHP
- ❌ Not escaping output
- ❌ Not sanitizing input
- ❌ Using `echo` without escaping
- ❌ Hardcoding URLs
- ❌ Not using text domain for translations
- ❌ Using short PHP tags `<?`

### JavaScript
- ❌ Global variables
- ❌ Missing 'use strict'
- ❌ Not using spaces in control structures
- ❌ Using `var` instead of `const`/`let`
- ❌ Inline event handlers

## Reference Files

- `.claude/skills/design-patterns.md` - Complete patterns guide
- `.cursor/rules/` - Technology-specific standards
