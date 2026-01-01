# Skeleton - WordPress Theme

## Overview

Custom WordPress theme built with vanilla JavaScript, SCSS, and PHP following WordPress coding standards. Uses ACF blocks for content editing.

## Key Principles

- Add js-\* to any element targeted using javascript
- Use js-\* class when you add or remove an class using javascript
- WCAG 2.1 AA compliance required
- Use ACF fields for theme options
- Always use arrow functions and IIFE pattern for JavaScript
- Never use inline styles
- Never use jQuery
- Never use !important
- Use tabs for indentation (not spaces)

## Build & Development

- `npm run dev` / `npm start`: Start development server with BrowserSync and watch tasks
- `npm run build`: Production build (includes PurgeCSS and minification)
- `npm run clean`: Remove `dist` directory

## Linting

- `npm run lint:js`: Lint JavaScript files using ESLint
- `npm run lint:css`: Lint SCSS files using Stylelint

## ACF Blocks

- **Registration**: Add block names to the `$block_types` array in `functions/register-acf-blocks.php`.
- **Auto-generation**: On local environments, adding a block to `$block_types` automatically creates:
    - `acf-blocks/{block-slug}.php` (Template)
    - `src/sass/partials/acf-blocks/_{block-slug}.scss` (Styles)
    - `src/js/custom/acf-blocks/{block-slug}.js` (Optional JS, if added to `$blocks_with_js`)
- **Styles**: Import new block SCSS in `src/sass/style.scss`.

## Important Patterns

### SCSS

- Use `@include media-breakpoint-up()`, and follow mobile first approach
- Use `fluid()` for responsive values
- Use `rem-calc()` for fixed values
- Use variables or custom properties if defined
- Never use inline styles
- Never use !important

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

// ❌ NEVER do this
@media (min-width: 768px) {
}
@media (max-width: 768px) {
}
@media screen and (min-width: 992px) {
}

// ✅ ALWAYS use media-breakpoint-up()
@include media-breakpoint-up(md) {
}
@include media-breakpoint-up(lg) {
}
@include media-breakpoint-up(xl) {
}
```

### WordPress/PHP

- Follow official WordPress coding standards
- Text domain is 'skel'
- Use `skel_` prefix for custom PHP functions
- Use esc_html() for outputting text
- Use esc_html_e() for outputting text with translation
- Use esc_html\_\_() for assigning it to a variable or passing it as an argument for a function or method
- Use esc_attr() for outputting attributes
- Use esc_attr_e() for outputting attributes with translation
- Use esc_attr\_\_() for assigning it to a variable or passing it as an argument for a function or method
- Use esc_url() for outputting URLs
- Use esc_url_e() for outputting URLs with translation
- Use esc_url\_\_() for assigning it to a variable or passing it as an argument for a function or method

```php
// ✅ Correct - WordPress standards with skel_ prefix
function skel_function_name() {
	$variable_name = get_option( 'option_name' );
	return esc_html( $variable_name );
}

// ✅ Correct
function skel_enqueue_scripts() { }
__( 'Text', 'skel' );
esc_html_e( 'Skip to content', 'skel' );

// ❌ Wrong
function skeleton_enqueue_scripts() { }
__( 'Text', 'skeleton' );

// Functions: lowercase with underscores, prefixed with skel_
function skel_get_custom_logo() { }
function skel_enqueue_scripts() { }

// Variables: lowercase with underscores
$post_id = get_the_ID();
$header_options = get_field( 'header', 'option' );
$custom_field = get_post_meta( $post_id, '_custom_field', true );

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

## Reference Files

- **`AGENTS.md`** - Detailed AI agent guidelines (PRIMARY)
- **`.claude/skills/design-patterns.md`** - Complete patterns guide
- **`.cursor/rules/`** - Technology-specific standards
- **`README.md`** - Setup and formatting guide
