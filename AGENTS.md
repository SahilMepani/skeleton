# AI Agent Guidelines for Skeleton WordPress Theme

## Project Structure

```
skeleton/
├── acf-blocks/                 # ACF block templates
│   ├── preview/                # Block preview images
│   ├── hero-slider.php
│   ├── faqs.php
│   └── ...
├── functions/                  # PHP function files
│   ├── define-constants.php
│   ├── enqueue-scripts.php
│   ├── helpers.php
│   ├── hooks.php
│   ├── register-acf-blocks.php
│   └── ...
├── images/
│   ├── icons/                  # SVG icons
│   ├── placeholder/            # Placeholder images
│   └── svg/                    # SVG assets
├── js/                         # Compiled JavaScript
│   ├── custom.js
│   ├── plugins.js
│   └── vendor/
├── src/
│   ├── js/
│   │   ├── custom/             # Custom JavaScript files
│   │   │   ├── acf-blocks/     # Block-specific JS
│   │   │   ├── data-toggle.js
│   │   │   ├── header-menu.js
│   │   │   └── ...
│   │   └── plugins/            # Third-party plugins
│   │       ├── swiper.js
│   │       ├── lenis.js
│   │       └── ...
│   └── sass/
│       ├── partials/
│       │   ├── acf-blocks/     # Block styles
│       │   ├── components/     # Component styles
│       │   ├── config/         # Configuration
│       │   │   ├── _colors.scss
│       │   │   ├── _maps.scss
│       │   │   ├── _typography.scss
│       │   │   └── _variables.scss
│       │   ├── helpers/        # Helper classes
│       │   ├── mixins/         # SCSS mixins
│       │   │   ├── _breakpoints.scss
│       │   │   ├── _rem.scss
│       │   │   └── ...
│       │   ├── templates/      # Template styles
│       │   ├── utilities/      # Utility classes
│       │   └── ...
│       └── style.scss          # Main stylesheet
├── template-parts/             # Reusable template parts
├── templates/                  # Page templates
├── functions.php               # Main functions loader
├── header.php
├── footer.php
├── style.css                   # Compiled CSS (auto-generated)
└── index.php
```

### HTML/PHP

Class Name:
Always use lowercase separated by hypens

```html
// Full-width sections should have a section tag and its class name to end with
*-section
<section class="hero-section"></section>
<section class="banner-section"></section>

// All sections should always have a direct children named .container
<section class="*-section">
	<div class="container"></div>
</section>

// Any wrapper class should be called *-block
<div class="img-block">
	<img src="" />
</div>
<div class="content-block">
	<h2>This is a heading</h2>
	<p>lorem ipsum is a paragraph text</p>
</div>

// All the images except the background pattern should be added as following. In
this case the img-cover-block should have a aspect ratio explicitly set
<div class="img-cover-block">
	<img src="" class="img-cover" />
</div>
```

## Critical Rules - NEVER Violate

### 1. Never Use Inline Styles

```php
// ❌ NEVER do this
<div style="color: red; padding: 20px;">

// ✅ Always use classes
<div class="component">
```

### 2. Never Use Raw px Values in SCSS

```scss
// ❌ NEVER do this
.component {
	font-size: 18px;
	padding: 24px;
	margin-block-end: 32px;
}

// ✅ Use rem-calc() for fixed values
.component {
	font-size: rem-calc(18);
	padding: rem-calc(24);
	margin-block-end: rem-calc(32);
}

// ✅ Use fluid() for responsive values (mobile, desktop)
.component {
	font-size: fluid(16, 18);
	padding: fluid(16, 24);
	margin-block-end: fluid(24, 32);
}
```

**Exceptions where px is allowed:**

- Very small values (under 4px)

### 3. Never Use @media Breakpoints Directly

```scss
// ❌ NEVER do this
@media (min-width: 768px) {
}
@media (max-width: 768px) {
}
@media screen and (min-width: 992px) {
}

// ✅ ALWAYS use
@media (width >= $md) {
}
@media (width >= $lg) {
}
@media (width >= $xl) {
}
```

### 4. Never Use Desktop-First mediq queries

```scss
// ❌ NEVER do this - Desktop-first approach
.component {
	font-size: fluid(24, 32);

	@media (width < $md) {
		font-size: fluid(16, 20);
	}
}

// ✅ Always mobile-first with media-queries-up
.component {
	font-size: fluid(16, 20);

	@media (width >= $lg) {
		font-size: fluid(24, 32);
	}
}
```

## SCSS Standards

### The rem-calc() Function

Use `rem-calc()` for single pixel values that don't need to scale responsively.

```scss
// rem-calc() converts px to rem
// Usage: rem-calc(value) - without px unit

border-radius: rem-calc(8);
gap: rem-calc(16);
border-width: rem-calc(2);
```

### The fluid() Function

Use `fluid()` for responsive values that scale between mobile and desktop.

```scss
// fluid(min-value, max-value, min-breakpoint, max-breakpoint)
// Breakpoints default to 'md' and 'xxl'

// Basic usage (mobile value, desktop value)
font-size: fluid(16, 24);
padding: fluid(20, 40);
margin-block-end: fluid(32, 64);

// With custom breakpoints (use breakpoint names, not px)
font-size: fluid(16, 24, md, xl);
```

### Breakpoint System

```scss
// Available breakpoints (mobile-first)
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
} // 576px and up
@media (width >= $md) {
} // 768px and up
@media (width >= $lg) {
} // 992px and up
@media (width >= $xl) {
} // 1200px and up
@media (width >= $xxl) {
} // 1400px and up
```

### SCSS File Organization

Import order in `style.scss`:

```scss
// 1. Mixins (utilities first)
@import 'partials/mixins/rem';

// 2. Config (variables, colors, etc.)
@import 'partials/config/maps';
@import 'partials/config/colors';
@import 'partials/config/typography';
@import 'partials/config/variables';

// 3. Mixins (rest)
@import 'partials/mixins/breakpoints';
@import 'partials/mixins/placeholders';
@import 'partials/mixins/containers';
// ... other mixins

// 4. Base styles
@import 'partials/reset';
@import 'partials/reboot';
@import 'partials/base-selectors';

// 5. JS Plugins (for easy overwrite)
@import 'partials/js-plugins/swiper';
// ... other plugins

// 6. Components
@import 'partials/components/header';
@import 'partials/components/footer';
// ... other components

// 7. Template Parts
@import 'partials/template-parts/swiper-navigation';
// ... other template parts

// 8. ACF Blocks
@import 'partials/acf-blocks/hero-slider';
// ... other blocks

// 9. Templates
@import 'partials/templates/index';
// ... other templates

// 10. WP Plugins
@import 'partials/wp-plugins/gravity-forms';

// 11. Helpers & Utilities (last for override capability)
@import 'partials/helpers/buttons';
@import 'partials/utilities/images';
```

### Naming Conventions

```scss
// Use lowercase with hyphens for class names
.hero-slider-section {
}
.header-nav-toggle {
}

// Use tabs for indentation (not spaces)
.component {
	display: flex;
	gap: rem-calc(16);

	@media (width >= $md) {
		gap: fluid(16, 32);
	}
}
```

## PHP Standards (WordPress)

### Text Domain & Prefix

```php
// Text domain: 'skel'
// Function prefix: skel_

// ✅ Correct
function skel_enqueue_scripts() { }
__( 'Text', 'skel' );
esc_html_e( 'Skip to content', 'skel' );

// ❌ Wrong
function skeleton_enqueue_scripts() { }
__( 'Text', 'skeleton' );
```

### Naming Conventions

```php
// Functions: lowercase with underscores, prefixed with skel_
function skel_get_custom_logo() { }
function skel_enqueue_scripts() { }

// Variables: lowercase with underscores
$post_id = get_the_ID();
$header_options = get_field( 'header', 'option' );
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

// Array syntax (short syntax preferred)
$array = [
	'key1' => 'value1',
	'key2' => 'value2',
];

// Tabs for indentation
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

### Template Structure

```php
// ACF Block template pattern
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
		<!-- Block content -->
	</div>

</section>
```

## JavaScript Standards

### Arrow Function IIFE Pattern (Required)

```javascript
(() => {
	// All code here - 'use strict' is implicit
	const init = () => {
		// Initialize components
	};

	// Code runs immediately
	init();
})();
```

### Formatting Rules

```javascript
// NO spaces inside parentheses (standard JS formatting)
if (condition) {
}
document.querySelector('.selector');
functionName(arg1, arg2);

// Tabs for indentation
const element = document.querySelector('.element');

// camelCase for variables and functions
const headerNavToggle = document.querySelector('.header-nav-toggle');
const handleClick = event => {};

// Use const by default, let when reassignment needed
const items = [];
let counter = 0;
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

// Arrow functions in event listeners
headerNavToggle.addEventListener('click', e => {
	e.preventDefault();
	toggleNavigation();
});
```

### DOM Ready Pattern

```javascript
(() => {
	// Cache DOM elements
	const element = document.querySelector('.element');

	// Early return if element doesn't exist
	if (!element) return;

	// Initialize functionality
	element.addEventListener('click', handleClick);
})();
```

### Class Toggling Pattern

```javascript
// Use 'js-' prefix for JS-controlled classes
const activeClass = 'js-active';
const popupActiveClass = 'js-popup-active';

element.classList.add(activeClass);
element.classList.remove(activeClass);
element.classList.toggle(activeClass);
element.classList.contains(activeClass);
```

## Animation using data attributes

### Key Data Attributes

**`data-inview`**

- Marks elements to be observed. When element enters viewport, `data-inview="true"` is set.

**`data-inview-repeat`**

- Similar to `data-inview`, but attribute is removed when element exits viewport.

**`data-inview-offset`**

- Specifies offset when element is considered in view. Can be pixel or percentage.

**`data-inview-threshold`**

- Proportion of element that needs to be visible. Default is `0.05` (5%).

**`data-aos`**

- Animation type to apply. Runs when `data-inview="true"`.
- Example: `data-aos="fade-up"`

**`data-aos-stagger-item`**

- Used for staggered animations among child elements.

### CSS Custom Properties for Animations

```scss
// Set on parent element or globally
--aos-duration: 1000ms;
--aos-delay: 0ms;
--aos-stagger-interval: 100ms; // For staggered items
--aos-distance: 40px;
```

## Toggle state/class using data attributes

### Key Data Attributes

**`data-toggle-click`**

- Toggles `js-active` class when clicked.

**`data-toggle-group`**

- Groups elements together. Only one element in group has `js-active` at a time.

**`data-toggle-link`**

- Links elements to toggle `js-active` in unison.

**`data-toggle-hover`**

- Toggles `js-active` class on hover.

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

## Common Mistakes to Avoid

### SCSS

- ❌ Using raw `px` values - Use `rem-calc()` or `fluid()`
- ❌ Desktop-first approach
- ❌ Using spaces for indentation - Use tabs
- ❌ Using IDs for styling

### PHP

- ❌ Not escaping output
- ❌ Not sanitizing input
- ❌ Using wrong text domain (`skeleton` instead of `skel`)
- ❌ Using wrong function prefix (`skeleton_` instead of `skel_`)
- ❌ Hardcoding URLs
- ❌ Using short PHP tags `<?`

### JavaScript

- ❌ Global variables
- ❌ Using `var` instead of `const`/`let`
- ❌ Using IIFE with function keyword - Use arrow function IIFE
- ❌ Inline event handlers in HTML
- ❌ Using spaces inside parentheses

## ACF Block Registration & Auto-generation

The theme uses an automated system to register and create ACF blocks.

### 1. Registering a Block

Add the block name (Title Case) to the `$block_types` array in `functions/register-acf-blocks.php`.

```php
$block_types = array(
	'Hero Slider',
	'Faqs',
	'New Block Name', // Add here
);
```

### 2. Blocks with JavaScript

If the block requires a dedicated JS file, add it to the `$blocks_with_js` array.

```php
$blocks_with_js = array(
	'Hero Slider',
	'New Block Name',
);
```

### 3. Auto-generated Files

On local environments, the system automatically creates the following files based on the sanitized name:

- `acf-blocks/new-block-name.php`
- `src/sass/partials/acf-blocks/_new-block-name.scss`
- `src/js/custom/acf-blocks/new-block-name.js` (if in `$blocks_with_js`)

## Key Helper Functions

### SVG Icons

Use the `svg()` function to output SVG icons from the sprite.

```php
<?php echo svg( 'arrow-right', [ 'class' => 'custom-class' ] ); ?>
```

### Phone URLs

Sanitize and format phone numbers for `tel:` links.

```php
<a href="<?php echo skel_get_phone_url( '+971 50 123 4567' ); ?>">Call Us</a>
```

### Excerpts

Get a customized excerpt with a word limit.

```php
<?php echo skel_get_the_excerpt( 20 ); ?>
```

## RTL & Multi-language Support (WPML)

The theme includes helper classes for RTL support, primarily for Arabic.

### Direction Classes

- `skel_direction_class()`: Returns `dir-rtl` or `dir-ltr`.
- `skel_swiper_direction_class()`: Returns `swiper-rtl` or `swiper`.

```php
<div class="component <?php echo esc_attr( skel_direction_class() ); ?>">
	<!-- Content -->
</div>
```

## Build & Development Commands

- `npm run dev`: Start development server (BrowserSync + Watch).
- `npm run build`: Production build (PurgeCSS + Minification).
- `npm run lint:js`: Lint JavaScript.
- `npm run lint:css`: Lint SCSS.

## Reference Files

- `.claude/skills/design-patterns.md` - Complete patterns guide
- `.cursor/rules/` - Technology-specific standards
- `README.md` - Setup and formatting guide
