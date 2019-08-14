<?php
/**
 * The file that defines the custom fields
 *
 * @link       https://github.com/agrilife/af4-aglifesciences/blob/master/fields/study-abroad-search-fields.php
 * @since      0.2.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/fields
 */

if ( function_exists( 'acf_add_local_field_group' ) ) :

	acf_add_local_field_group(
		array(
			'key'                   => 'group_5d27406558858',
			'title'                 => 'Study Abroad Search',
			'fields'                => array(
				array(
					'key'               => 'field_5d27406cdd6a3',
					'label'             => '',
					'name'              => 'study_abroad_search',
					'type'              => 'group',
					'instructions'      => '',
					'required'          => 0,
					'conditional_logic' => 0,
					'wrapper'           => array(
						'width' => '',
						'class' => '',
						'id'    => '',
					),
					'layout'            => 'block',
					'sub_fields'        => array(
						array(
							'key'               => 'field_5d274083dd6a4',
							'label'             => 'Degree Level',
							'name'              => 'degree_level',
							'type'              => 'taxonomy',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'taxonomy'          => 'level',
							'field_type'        => 'select',
							'allow_null'        => 0,
							'add_term'          => 0,
							'save_terms'        => 0,
							'load_terms'        => 0,
							'return_format'     => 'object',
							'multiple'          => 0,
						),
					),
				),
			),
			'location'              => array(
				array(
					array(
						'param'    => 'page_template',
						'operator' => '==',
						'value'    => 'study-abroad-search.php',
					),
				),
			),
			'menu_order'            => 0,
			'position'              => 'acf_after_title',
			'style'                 => 'default',
			'label_placement'       => 'top',
			'instruction_placement' => 'label',
			'hide_on_screen'        => '',
			'active'                => true,
			'description'           => '',
		)
	);

endif;
