<?php

return [

	/**
	 * These fields are automatically added to all WP Users, and automatically
	 * retrieved when formatting a post.
	 */
	'author-fields' => [
		[ 'image', 'Photo', [
			'dimensions' => '200x200'
		]],
		[ 'text', 'Name', ['required' => 1] ],
		[ 'text', 'Role' ],
		[ 'textarea', 'Description', [
			'new_lines' => 'wpautop'
		]]
	],

	/**
	 * This is the list of button styles available on the site. They will be
	 * displayed as options for the user in some ACF fields, as well as the
	 * rich text editor.
	 */
	'button-styles' => [
		'primary' => 'Primary',
		'outline' => 'Outline',
		'secondary' => 'Secondary',
	],

	/**
	 * This is the list of text colors available in the rich text editor.
	 * They are displayed as formatting options for the user.
	 *
	 * Keys should always be HEX color codes (without the #), and values
	 * should be their names.
	 */
	'editor-text-colors' => [
		'000000' => 'Black',
		'FFFFFF' => 'White',
		'151728' => 'Dark',
		'7A979F' => 'Grey',
		'A2B6BD' => 'Light Grey',
		'876E2F' => 'Gold',
		'226DF6' => 'Links Primary',

	],

	/**
	 * This is the list of text styles available in the rich text editor. They
	 * are grouped by category, and displayed as formatting options for the user.
	 *
	 * Keys should be the class name, while values should be an array containing
	 * the HTML tag ('p', 'span', etc.) and a label to describe the text style.
	 */
	'editor-text-styles' => [
		[
			'title' => 'Paragraphs',
			'items' => [
				'text-normal' => [ 'p', 'Normal' ],
				'text-large' => [ 'p', 'Large' ],
				'text-caption' => [ 'p', 'Caption' ]
			]
		],
		[
			'title' => 'Displays',
			'items' => [
				'display-1' => [ 'h2', 'Display 1' ],
			]
		],
		[
			'title' => 'Headings',
			'items' => [
				'heading-1' => [ 'h2', 'Heading 1' ],
				'heading-2' => [ 'h2', 'Heading 2' ],
				'heading-3' => [ 'h3', 'Heading 3' ],
				'heading-4' => [ 'h4', 'Heading 4' ],
				'heading-5' => [ 'h5', 'Heading 5' ],
				'heading-6' => [ 'h6', 'Heading 6' ]
			]
		]
	],

	/**
	 * These are the default media sizes in WordPress. It replaces the media sizes
	 * present in 'Settings > Media'.
	 */
	'media-sizes' => [
		'thumbnail' => 600,
		'medium' => 1280,
		'large' => 1920
	],

	/**
	 * These fields will be automatically added to all posts, alongside
	 * the 'thumbnail' and 'excerpt' fields. They are also retrieved
	 * automatically in the formatted post.
	 */
	'post-generic-fields' => [
		[ 'true_false', 'Translucent Header', [
			'default_value' => false
		]],
		[ 'true_false', 'Sticky CTA', [
			'default_value' => false
		]]
	],


	/**
	 * These fields will be automatically added to all sections, alongside
	 * the 'anchor' and 'spacing-config' fields. They are also retrieved
	 * automatically in the formatted section.
	 */
	'section-generic-fields' => [],

	/**
	 * These are the default Social Media options that will be available for the user.
	 */
	'social-media-options' => [
		'facebook' => 'Facebook',
		'instagram' => 'Instagram',
		'tiktok' => 'TikTok',
		'twitter' => 'Twitter',
		'youtube' => 'Youtube'
	]
];
