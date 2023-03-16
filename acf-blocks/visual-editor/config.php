<?php
	return [
		'title' => 'Visual Editor',
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
		]
	];
?>
