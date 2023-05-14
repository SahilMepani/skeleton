<?php
	return [
		'title' => 'Visual Editor',
		'key' => 'group_6460b71f48a46',
		'fields' => [
			[
				'key' => 'field_6411d664fdf12',
				'label' => 'Sample Logic',
				'name' => 'sample_logic',
				'aria-label' => '',
				'type' => 'true_false',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'message' => '',
				'default_value' => 1,
				'ui_on_text' => '',
				'ui_off_text' => '',
				'ui' => 1,
			],
			[
				'key' => 'field_63a28b608aaa4',
				'label' => 'Text',
				'name' => 'text',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => [
					[
						[
							'field' => 'field_6411d664fdf12',
							'operator' => '==',
							'value' => '1',
						],
					],
				],
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			],
			[
				'key' => 'field_63a28b6a8aaa5',
				'label' => 'Link',
				'name' => 'link',
				'aria-label' => '',
				'type' => 'link',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'return_format' => 'array',
			]
		],
		'location' => array(
			array(
				array(
					'param' => 'block',
					'operator' => '==',
					'value' => 'acf/visual-editor',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	];
?>
