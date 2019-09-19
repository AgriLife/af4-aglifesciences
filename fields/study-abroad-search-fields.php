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
							'label'             => 'Student Level',
							'name'              => 'student_level',
							'type'              => 'taxonomy',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'taxonomy'          => 'study-abroad-classification',
							'field_type'        => 'multi_select',
							'allow_null'        => 0,
							'add_term'          => 0,
							'save_terms'        => 0,
							'load_terms'        => 0,
							'return_format'     => 'object',
							'multiple'          => 0,
						),
						array(
							'key'               => 'field_6d829000718d1',
							'label'             => 'Exclude Taxonomies From Search Filters',
							'name'              => 'exclude_tax_from_search_filters',
							'type'              => 'select',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'none'                    => 'None',
								'study-abroad-department' => 'Department',
								'study-abroad-region'     => 'Region',
								'study-abroad-term'       => 'Term',
								'study-abroad-program-type' => 'Program Type',
								'study-abroad-classification' => 'Classification',
							),
							'default_value'     => array(
								0 => 'none',
							),
							'allow_null'        => 1,
							'multiple'          => 1,
							'ui'                => 0,
							'return_format'     => 'value',
							'ajax'              => 0,
							'placeholder'       => '',
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
