<?php
/**
 * The file that defines the custom fields
 *
 * @link       https://github.com/agrilife/af4-aglifesciences/blob/master/fields/student-organization-fields.php
 * @since      0.7.2
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/fields
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_5d8d03f8e3faf',
			'title'                 => 'Organization Information',
			'fields'                => array(
				array(
					'key'               => 'field_5d8d0402a7643',
					'label'             => 'Link',
					'name'              => 'link',
					'type'              => 'link',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'return_format'     => 'array',
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'student-organization',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'normal',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

endif;
