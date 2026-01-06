# Design Patterns - Skeleton WordPress Theme

This document captures the established design patterns, conventions, and best practices for the Skeleton WordPress theme.

## Table of Contents

1. [Critical Rules](#critical-rules)
2. [SCSS Patterns](#scss-patterns)
3. [PHP Patterns](#php-patterns)
4. [JavaScript Patterns](#javascript-patterns)
5. [Component Architecture](#component-architecture)
6. [Data Attribute System](#data-attribute-system)
7. [Accessibility Standards](#accessibility-standards)
8. [File Organization](#file-organization)

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

// ✅ Use rem-calc() for fixed values
.component {
	gap: rem-calc(16);
	border-radius: rem-calc(8);
}

// ✅ Use fluid() for responsive values
.component {
	font-size: fluid(16, 18);
	padding: fluid(16, 24);
	margin-bottom: fluid(24, 32);
}
```

**Exceptions where px is allowed:**

- `1px` borders
- Box shadows
- Very small values (under 4px)

#### 3. No @media Breakpoints Directly

```scss
// ❌ NEVER
@media (min-width: 768px) {
}
@media (max-width: 768px) {
}
@media (min-width: 992px) {
}

// ✅ ALWAYS use media queries up
@media (width >= $md) {
}
@media (width < $md) {
}
@media (width >= $lg) {
}
```

#### 4. No Desktop-First / No media queries with max-width

```scss
// ❌ NEVER - Desktop-first
.component {
	font-size: fluid(24, 32);
	grid-template-columns: repeat(3, 1fr);

	@media (width < $md) {
		font-size: fluid(16, 20);
		grid-template-columns: 1fr;
	}
}

// ✅ ALWAYS mobile-first
.component {
	font-size: fluid(16, 20);
	grid-template-columns: 1fr;

	@media (width >= $lg) {
		font-size: fluid(24, 32);
		grid-template-columns: repeat(3, 1fr);
	}
}
```

---

## SCSS Patterns

### The rem-calc() Function

Use for single pixel values that don't need responsive scaling.

```scss
// rem-calc(value) - converts px to rem
// Pass the value WITHOUT px unit

border-radius: rem-calc(8);
gap: rem-calc(16);
border-width: rem-calc(2);
padding: rem-calc(24);

// Can accept multiple values
padding: rem-calc(16) rem-calc(24);
```

### The fluid() Function

Use for responsive values that scale between mobile and desktop.

```scss
// fluid(min-value, max-value, min-breakpoint, max-breakpoint)
// Default breakpoints: 'sm' to 'xxl'
// Values are unitless (px implied)

// Basic usage (mobile value, desktop value)
font-size: fluid(16, 24);
padding: fluid(20, 40);
margin-bottom: fluid(32, 64);
gap: fluid(16, 32);

// With custom breakpoints (use names, not px)
font-size: fluid(16, 24, md, xl);
```

### Breakpoint System (Mobile-First ONLY)

```scss
// Available breakpoints
$grid-breakpoints: (
	'xs': 0,
	'ph': 23.4375rem,
	// 375px
	'sm': 36rem,
	// 576px
	'md': 48rem,
	// 768px
	'lg': 62rem,
	// 992px
	'xl': 75rem,
	// 1200px
	'xxl': 87.5rem,
	// 1400px
	'xxxl': 100rem // 1600px
);

// Usage (mobile-first ONLY)
@media (width >= $sm) {
} // 576px+
@media (width >= $md) {
} // 768px+
@media (width >= $lg) {
} // 992px+
@media (width >= $xl) {
} // 1200px+
@media (width >= $xxl) {
} // 1400px+
```

**Usage Pattern:**

```scss
.component {
	// Mobile styles (default)
	display: flex;
	flex-direction: column;
	padding: fluid(16, 20);

	@media (width >= $md) {
		// Tablet and up (768px+)
		flex-direction: row;
		padding: fluid(20, 32);
	}

	@media (width >= $lg) {
		// Desktop and up (992px+)
		padding: fluid(32, 48);
	}
}
```

### Naming Conventions

```scss
// Use lowercase with hyphens for class names
.hero-slider-section {
}
.header-nav-toggle {
}
.site-header {
}

// Section naming (full-width blocks)
.block-name-section {
}

// JS-controlled classes use 'js-' prefix
.js-active {
}
.js-popup-active {
}

// Inner wrappers (rare)
.inner-section {
}
```

### CSS Variables Pattern

```scss
// Global variables
:root {
	--header-height: #{rem-calc(65)};
	--container-padding-x: #{fluid(20, 40)};
	--custom-ease: cubic-bezier(0.215, 0, 0, 0.995);
}

// Component-scoped variables
.card {
	--card-padding: #{fluid(16, 24)};
	padding: var(--card-padding);
}
```

### Grid Layout Pattern

```scss
.grid {
	display: grid;
	gap: fluid(16, 32);
	grid-template-columns: 1fr;

	@media (width >= $md) {
		grid-template-columns: repeat(2, 1fr);
	}

	@media (width >= $lg) {
		grid-template-columns: repeat(3, 1fr);
	}

	@media (width >= $xl) {
		grid-template-columns: repeat(4, 1fr);
	}
}
```

### Flexbox Pattern

```scss
.flex-container {
	display: flex;
	flex-direction: column;
	gap: fluid(12, 16);

	@media (width >= $md) {
		flex-direction: row;
		align-items: center;
		justify-content: space-between;
	}
}
```

### Full-Height Section Pattern

```scss
.hero-section {
	block-size: calc(100svh - var(--header-height, rem-calc(65)));
	position: relative;
}
```

---

## PHP Patterns

### Theme Prefix & Text Domain

```php
// Function prefix: skel_
// Text domain: 'skel'

function skel_enqueue_scripts() { }
__( 'Text', 'skel' );
esc_html_e( 'Skip to content', 'skel' );
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
echo esc_html__( 'Text', 'skel' );
esc_html_e( 'Text', 'skel' );
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
get_template_part( 'template-parts/swiper-navigation', null, [
	'style' => 'floating',
] );

// In template part
$style = $args['style'] ?? 'default';
```

### ACF Block Template Pattern

```php
<?php
// Set thumbnail preview in backend.
if ( isset( $block['data']['preview_image'] ) ) {
	echo '<img src="' . esc_url( $block['data']['preview_image'] ) . '" style="width:100%; height:auto;">';
	return;
}

// Return early if display is off.
$display = get_field( 'display' );
if ( 'on' !== $display ) {
	return;
}

// Data options
$items = get_field( 'items' );

if ( ! is_array( $items ) || empty( $items ) ) {
	return;
}

// Developer options
$spacing        = get_field( 'spacing' );
$spacing_top    = $spacing['top']['spacing_top'] ?? '';
$spacing_bottom = $spacing['bottom']['spacing_bottom'] ?? '';
$custom_classes = get_field( 'custom_classes' );
$custom_css     = get_field( 'custom_css' );
$unique_id      = get_field( 'unique_id' );
?>

<section
	class="block-name-section section <?php echo esc_attr( "section-display-{$display} {$spacing_top} {$spacing_bottom} {$custom_classes}" ); ?>"
	style="<?php echo esc_attr( $custom_css ); ?>"
	id="<?php echo esc_attr( $unique_id ); ?>"
	data-inview>

	<div class="container">
		<?php foreach ( $items as $item ) : ?>
			<!-- Item content -->
		<?php endforeach; ?>
	</div>

</section>
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
	<p><?php esc_html_e( 'No posts found.', 'skel' ); ?></p>
<?php endif; ?>
```

### Hooks Pattern

```php
// Actions
add_action( 'after_setup_theme', 'skel_setup' );
add_action( 'wp_enqueue_scripts', 'skel_enqueue_scripts' );
add_action( 'widgets_init', 'skel_register_sidebars' );

// Filters
add_filter( 'body_class', 'skel_body_classes' );
add_filter( 'script_loader_tag', 'modify_script_attributes', 10, 3 );
```

---

## JavaScript Patterns

### Arrow Function IIFE Pattern (Required)

```javascript
(() => {
	// All code here
	// 'use strict' is implicit

	// Cache DOM elements
	const element = document.querySelector('.element');

	// Early return if element doesn't exist
	if (!element) return;

	// Initialize functionality
	element.addEventListener('click', handleClick);
})();
```

### Formatting Rules

```javascript
// NO spaces inside parentheses (standard JS)
if (condition) {
}
document.querySelector('.selector');
functionName(arg1, arg2);

// Tabs for indentation
const element = document.querySelector('.element');

// camelCase for variables and functions
const headerNavToggle = document.querySelector('.header-nav-toggle');
const handleClick = event => {};
```

### Event Handling

```javascript
// Named handler functions
const handleClick = event => {
	event.preventDefault();
	const target = event.currentTarget;
	// Handle click
};

element.addEventListener('click', handleClick);

// Arrow functions in listeners
headerNavToggle.addEventListener('click', e => {
	e.preventDefault();
	toggleNavigation();
});
```

### Class Toggling Pattern

```javascript
// Use 'js-' prefix for JS-controlled classes
const activeClass = 'js-active';
const popupActiveClass = 'js-popup-active';

// With ARIA attributes
const openNavigation = () => {
	headerNavToggle.classList.add(activeClass);
	headerNav.classList.add(activeClass);
	body.classList.add(popupActiveClass);
	body.setAttribute('data-lenis-prevent', 'true');

	headerNavToggle.setAttribute('aria-expanded', 'true');
	headerNav.setAttribute('aria-hidden', 'false');
};

const closeNavigation = () => {
	headerNavToggle.classList.remove(activeClass);
	headerNav.classList.remove(activeClass);
	body.classList.remove(popupActiveClass);
	body.removeAttribute('data-lenis-prevent');

	headerNavToggle.setAttribute('aria-expanded', 'false');
	headerNav.setAttribute('aria-hidden', 'true');
};
```

### Async/Await

```javascript
const fetchData = async url => {
	try {
		const response = await fetch(url);

		if (!response.ok) {
			throw new Error(`HTTP error! status: ${response.status}`);
		}

		return await response.json();
	} catch (error) {
		console.error('Fetch error:', error);
		return null;
	}
};
```

---

## Data Attribute System

### Animation Attributes (data-inview, data-aos)

**`data-inview`**

- Marks elements to be observed for viewport entry
- When element enters viewport, `data-inview="true"` is set

**`data-inview-repeat`**

- Similar to `data-inview`, but attribute is removed when element exits viewport

**`data-inview-offset`**

- Specifies offset for when element is considered in view (px or %)

**`data-inview-threshold`**

- Proportion of element visible before triggering. Default: `0.05` (5%)

**`data-aos`**

- Animation type to apply (e.g., "fade-up", "fade")
- Runs when `data-inview="true"`

**`data-aos-stagger-item`**

- Used for staggered animations among child elements

### CSS Custom Properties for Animations

```scss
--aos-duration: 1000ms;
--aos-delay: 0ms;
--aos-stagger-interval: 100ms;
--aos-distance: 40px;
```

### Toggle Attributes (data-toggle)

**`data-toggle-click`**

- Toggles `js-active` class when clicked

**`data-toggle-group`**

- Groups elements together. Only one has `js-active` at a time

**`data-toggle-link`**

- Links elements to toggle `js-active` in unison

**`data-toggle-hover`**

- Toggles `js-active` class on hover

**`data-toggle-lenis`**

- Adds/removes `data-lenis-prevent` on toggle

### Usage Examples

```html
<!-- Click toggle with group -->
<div data-toggle-click="example" data-toggle-group="group1"></div>

<!-- Linked elements -->
<div data-toggle-click="example"></div>
<div data-toggle-link="example"></div>

<!-- Animation on scroll -->
<section data-inview data-aos="fade-up">
	<div data-aos-stagger-item>Item 1</div>
	<div data-aos-stagger-item>Item 2</div>
</section>
```

### Other Data Attributes

**`data-esc`**

- Element closes on Escape key press

**`data-lenis-prevent`**

- Prevents Lenis smooth scroll on element

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
		top: fluid(8, 12);
		left: fluid(8, 12);
		z-index: 100000;
		width: auto;
		height: auto;
		padding: fluid(12, 16) fluid(20, 24);
		clip: auto;
		background: var(--color-background);
		color: var(--color-text);
	}
}
```

### Form Accessibility

```php
<label for="email-field">
	<?php esc_html_e( 'Email Address', 'skel' ); ?>
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
	<?php esc_html_e( 'We will never share your email.', 'skel' ); ?>
</p>
```

### Skip Link

```php
<a class="skip-link screen-reader-text" href="#site-content">
	<?php esc_html_e( 'Skip to content', 'skel' ); ?>
</a>
```

### ARIA Attributes

```php
// Navigation toggle
<button
	class="header-nav-toggle"
	aria-label="<?php esc_attr_e( 'show primary navigation', 'skel' ); ?>"
	aria-haspopup="true"
	aria-expanded="false"
	aria-controls="siteMenu">
	<?php esc_html_e( 'Menu', 'skel' ); ?>
</button>

<nav
	class="header-nav"
	aria-label="<?php esc_attr_e( 'primary navigation', 'skel' ); ?>"
	aria-hidden="true">
```

---

## File Organization

### Theme Structure

```
skeleton/
├── acf-blocks/                 # ACF block templates
│   └── preview/                # Block preview images
├── functions/                  # PHP function files
├── images/
│   ├── icons/                  # SVG icons
│   └── svg/                    # SVG assets
├── js/                         # Compiled JavaScript
├── src/
│   ├── js/
│   │   ├── custom/             # Custom JS files
│   │   └── plugins/            # Third-party plugins
│   └── sass/
│       ├── partials/
│       │   ├── acf-blocks/
│       │   ├── components/
│       │   ├── config/         # colors, maps, typography, variables
│       │   ├── helpers/
│       │   ├── mixins/         # breakpoints, rem
│       │   ├── templates/
│       │   └── utilities/
│       └── style.scss
├── template-parts/
├── templates/
├── functions.php
├── header.php
├── footer.php
├── style.css
└── index.php
```

### SCSS Import Order

```scss
// 1. Mixins (rem-calc first as it's used by config)
@import 'partials/mixins/rem';

// 2. Config
@import 'partials/config/maps';
@import 'partials/config/colors';
@import 'partials/config/typography';
@import 'partials/config/variables';

// 3. Rest of mixins
@import 'partials/mixins/breakpoints';
@import 'partials/mixins/placeholders';
@import 'partials/mixins/containers';
// ... other mixins

// 4. Base
@import 'partials/reset';
@import 'partials/reboot';
@import 'partials/base-selectors';

// 5. JS Plugins (for easy overwrite)
@import 'partials/js-plugins/swiper';
// ... other plugins

// 6. Base styles
@import 'partials/font-face';
@import 'partials/base-styles';

// 7. Components
@import 'partials/components/content';
@import 'partials/components/header';
// ... other components

// 8. Template Parts
@import 'partials/template-parts/swiper-navigation';
// ... other template parts

// 9. ACF Blocks
@import 'partials/acf-blocks/hero-slider';
// ... other blocks

// 10. Templates
@import 'partials/templates/index';
// ... other templates

// 11. WP Plugins
@import 'partials/wp-plugins/gravity-forms';

// 12. Helpers & Utilities (last)
@import 'partials/helpers/buttons';
@import 'partials/utilities/images';
```

---

## Quick Reference

### SCSS Cheat Sheet

```scss
// Fixed values (use rem-calc)
gap: rem-calc(16);
border-radius: rem-calc(8);

// Responsive values (use fluid)
font-size: fluid(16, 24);
padding: fluid(20, 40);
gap: fluid(16, 32);

// Breakpoints (mobile-first ONLY)
@media (width >= $sm) {
} // 576px+
@media (width >= $md) {
} // 768px+
@media (width >= $lg) {
} // 992px+
@media (width >= $xl) {
} // 1200px+
@media (width >= $xxl) {
} // 1400px+
```

### PHP Cheat Sheet

```php
// Escape output
esc_html( $text )
esc_attr( $attr )
esc_url( $url )
wp_kses_post( $html )

// Translate (text domain: 'skel')
__( 'Text', 'skel' )
esc_html__( 'Text', 'skel' )
esc_html_e( 'Text', 'skel' )

// Sanitize input
sanitize_text_field( $input )
sanitize_email( $email )
absint( $number )
```

### JavaScript Cheat Sheet

```javascript
// Arrow function IIFE
(() => {
	// code
})();

// Standard formatting (NO spaces in parentheses)
if (condition) {
}
document.querySelector('.class');
functionName(arg);

// Variables
const element = document.querySelector('.el');
let counter = 0;
```
