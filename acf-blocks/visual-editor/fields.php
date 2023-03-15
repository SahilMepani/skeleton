<?php
if ( function_exists('acf_add_local_field_group') ) :

	// get the name of the parent folder
	$group_slug = basename(__DIR__);

	$fields = [
		array(
			'key' => 'field_6411d664fdf12',
			'label' => 'Sample Logic',
			'name' => 'sample_logic',
			'aria-label' => '',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 1,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => '',
			'default_value' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
			'ui' => 1,
		),
		array(
			'key' => 'field_63a28b608aaa4',
			'label' => 'Text',
			'name' => 'text',
			'aria-label' => '',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_6411d664fdf12',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'maxlength' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
		),
		array(
			'key' => 'field_63a28b6a8aaa5',
			'label' => 'Link',
			'name' => 'link',
			'aria-label' => '',
			'type' => 'link',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'return_format' => 'array',
		)
	];

	$options = [
		'key'                   => 'group_' . md5( $group_slug ),
		'fields'                => $fields,
		'location'              => [
			[
				[
					'param'              => 'block',
					'operator'           => '==',
					'value'              => 'acf/' . $group_slug,
				],
			],
		],
		'menu_order'            => 0,
		'position'              => 'normal',
		'style'                 => 'default',
		'label_placement'       => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen'        => [ 0 => 'the_content' ],
		'active'                => true,
		'description'           => '',
		'show_in_rest'          => 0,
	];

	acf_add_local_field_group( $options );

endif;
?>