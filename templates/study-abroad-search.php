<?php
/**
 * The file that renders the study abroad search page
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/templates/study-abroad-search.php
 * @since      0.2.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/templates
 */

// Force page layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Move page heading before sidebar and content containers.
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_open', 5 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_entry_header_markup_close', 15 );
add_action( 'genesis_before_content_sidebar_wrap', 'genesis_do_post_title', 11 );

// Page content.
add_action( 'wp_enqueue_scripts', 'study_abroad_search_scripts', 12 );
add_action( 'genesis_before_content', 'study_abroad_filters' );
add_action( 'genesis_entry_content', 'study_abroad_content' );

/**
 * Enqueues scripts
 *
 * @since 0.3.0
 * @return void
 */
function study_abroad_search_scripts() {

	wp_enqueue_script( 'agrilife-post-tile-search' );

}

/**
 * Get degree program posts based on a custom field taxonomy.
 *
 * @since 0.1.0
 * @param array $args Args for a WP_Query call.
 * @return WP_Query object
 */
function asa_get_posts( $args = array() ) {

	// Get taxonomies of posts which have a given taxonomy term.
	$post_slug = 'study-abroad';
	$taxonomy  = 'study-abroad-classification';
	$fields    = get_field( 'study_abroad_search' );
	$levels    = $fields['student_level'];
	$args      = array_merge(
		array(
			'post_type'      => $post_slug,
			'posts_per_page' => -1,
			'orderby'        => 'title',
			'order'          => 'ASC',
		),
		$args
	);

	// Restrict posts to value of student levels custom field.
	if ( 0 < count( $levels ) ) {
		$args['tax_query'] = array(); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	foreach ( $levels as $level ) {

		$args['tax_query'][] = array(
			'taxonomy' => $taxonomy,
			'field'    => 'slug',
			'terms'    => $level->slug,
		);

	}

	return new WP_Query( $args );

}

/**
 * Show degree search filters.
 *
 * @since 0.1.0
 * @return void
 */
function study_abroad_filters() {

	$post_slug           = 'study-abroad';
	$taxonomies          = get_object_taxonomies( $post_slug );
	$excluded_taxonomies = get_field( 'study_abroad_search' )['exclude_tax_from_search_filters'];
	$id                  = 'study-abroad-sidebar-search';
	$button_mobile       = '<a class="post-tile-search-toggle ' . $post_slug . '-toggle title-bar-navigation" data-toggle="search-sidebar"><div class="menu-icon"></div><div>Filters</div></a>';
	$taxonomy_list       = implode( ',', $taxonomies );
	$output              = '';
	$query               = asa_get_posts( array( 'fields' => 'ids' ) );
	$post_ids            = $query->posts;
	$tax_terms           = array();
	$sidebar_defaults    = apply_filters(
		'genesis_widget_area_defaults',
		array(
			'before'              => genesis_markup(
				array(
					'open'    => '<aside id="search-sidebar" class="' . $post_slug . '-search-sidebar widget-area cell small-12 medium-3" data-toggler=".active" data-taxonomy-list="' . $taxonomy_list . '" data-post-tile-search><div class="sticky-target" data-options="marginTop:7;anchor:genesis-content;">' . $button_mobile . '<div id="filter-wrap">' . genesis_sidebar_title( $id ) . '<h2>Filter Programs<a href="#" data-post-tile-reset class="reset-search">Reset</a></h2>',
					'context' => 'widget-area-wrap',
					'echo'    => false,
					'params'  => array(
						'id' => $id,
					),
				)
			),
			'after'               => genesis_markup(
				array(
					'close'   => '</div></div></aside>',
					'context' => 'widget-area-wrap',
					'echo'    => false,
				)
			),
			'default'             => '',
			'show_inactive'       => 0,
			'before_sidebar_hook' => 'genesis_before_' . $id . '_widget_area',
			'after_sidebar_hook'  => 'genesis_after_' . $id . '_widget_area',
		),
		"{$post_slug}-sidebar-search",
		array()
	);

	if ( empty( $post_ids ) ) {

		return;

	}

	$output .= $sidebar_defaults['before'];

	foreach ( $taxonomies as $slug ) {
		$tax_terms[ $slug ] = get_terms(
			array(
				'taxonomy'   => $slug,
				'object_ids' => $post_ids,
			)
		);
	}

	// Remove taxonomies from search filters based on custom field selection.
	foreach ( $excluded_taxonomies as $taxonomy ) {
		if ( 'none' !== $taxonomy ) {
			unset( $tax_terms[ $taxonomy ] );
		}
	}

	// Taxonomy search bar output.
	$checkbox = '<li class="item grid-x"><input class="cell shrink %s-%s" type="checkbox" id="dept_%s" value="%s-%s"><label class="cell auto" for="dept_%s">%s</label></li>';
	$output  .= '<ul id="' . $post_slug . '-filters" class="reset">';
	foreach ( $tax_terms as $key => $value ) {
		$meta = get_taxonomy( $key );

		$output .= "<li><h3>{$meta->label}</h3>";
		$output .= '<ul>';

		foreach ( $value as $key2 => $value2 ) {
			$output .= sprintf(
				$checkbox,
				$value2->taxonomy,
				$value2->slug,
				$value2->term_id,
				$value2->taxonomy,
				$value2->slug,
				$value2->term_id,
				$value2->name
			);
		}
		$output .= '</ul></li>';
	}

	$output .= '</ul>';
	$output .= $sidebar_defaults['after'];

	// Output.
	echo wp_kses(
		$output,
		array(
			'button' => array(
				'class'             => array(),
				'type'              => array(),
				'data-toggle'       => array(),
				'data-toggle-focus' => array(),
				'aria-controls'     => array(),
			),
			'aside'  => array(
				'id'                    => array(),
				'class'                 => array(),
				'data-toggler'          => array(),
				'data-sticky-container' => array(),
				'data-taxonomy-list'    => array(),
				'data-post-tile-search' => array(),
			),
			'ul'     => array(
				'id'    => array(),
				'class' => array(),
			),
			'li'     => array(
				'class' => array(),
			),
			'a'      => array(
				'href'                 => array(),
				'class'                => array(),
				'data-toggle'          => array(),
				'data-toggle-focus'    => array(),
				'data-post-tile-reset' => array(),
				'aria-controls'        => array(),
			),
			'div'    => array(
				'id'              => array(),
				'class'           => array(),
				'data-sticky'     => array(),
				'data-sticky-on'  => array(),
				'data-options'    => array(),
				'data-margin-top' => array(),
				'data-anchor'     => array(),
				'data-top-anchor' => array(),
				'data-btm-anchor' => array(),
				'data-toggler'    => array(),
				'aria-expanded'   => array(),
			),
			'h2'     => array(),
			'h3'     => array(),
			'label'  => array(
				'class' => array(),
				'for'   => array(),
			),
			'input'  => array(
				'class'    => array(),
				'onchange' => array(),
				'type'     => array(),
				'id'       => array(),
				'value'    => array(),
			),
		)
	);

}

/**
 * Provide the post body content.
 *
 * @since 0.1.0
 * @return void
 */
function study_abroad_content() {

	$post_slug  = 'study-abroad';
	$output     = '<div class="grid-container full" data-post-search-tiles><div class="entries grid-x">';
	$entries    = asa_get_posts();
	$taxonomies = get_object_taxonomies( $post_slug );

	if ( empty( $entries->posts ) ) {

		return;

	}

	// Post list.
	foreach ( $entries->posts as $key => $post ) {

		$terms      = wp_get_post_terms( $post->ID, $taxonomies );
		$fields     = get_fields( $post->ID ) ? get_fields( $post->ID ) : array();
		$class      = [ 'entry', 'cell', 'medium-3', 'small-6' ];
		$thumb_id   = get_post_thumbnail_id( $post->ID );
		$thumb      = wp_get_attachment_image( $thumb_id, 'medium_cropped' );
		$tag        = 'div';
		$link       = array_key_exists( 'link', $fields ) ? $fields['link'] : false;
		$link_open  = $link ? "<a href=\"{$link}\" class=\"wrap\" title=\"{$post->post_title}\" target=\"_blank\">" : '<div class=\"wrap\">';
		$link_close = $link ? '</a>' : '</div>';

		foreach ( $terms as $term ) {
			$class[] = "{$term->taxonomy}-{$term->slug}";
		}

		if ( empty( $thumb ) ) {
			$thumb = sprintf(
				'<img alt="Image unavailable" src="%simages/default.svg" style="border:1px solid black;" />',
				AGDPR_DIR_URL
			);
		}

		$open = sprintf(
			'<%s class="%s">%s',
			$tag,
			implode( ' ', $class ),
			$link_open
		);

		$close = "{$link_close}</{$tag}>";

		$output .= sprintf(
			'%s%s<div class="title"><div class="truncate">%s</div></div>%s',
			$open,
			$thumb,
			$post->post_title,
			$close
		);

	}

	$output .= '</div></div>';

	// Output.
	echo wp_kses(
		$output,
		array(
			'div' => array(
				'class'                  => array(),
				'data-post-search-tiles' => array(),
			),
			'a'   => array(
				'href'   => array(),
				'class'  => array(),
				'title'  => array(),
				'target' => array(),
			),
			'img' => array(
				'alt'   => array(),
				'src'   => array(),
				'style' => array(),
			),
		)
	);

}

get_header();
genesis();
