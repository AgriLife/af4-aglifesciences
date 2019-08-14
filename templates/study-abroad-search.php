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
add_action( 'genesis_before_content', 'study_abroad_filters' );
add_action( 'genesis_entry_content', 'study_abroad_content' );

/**
 * Get degree program posts based on a custom field taxonomy.
 *
 * @since 0.1.0
 * @param array $args Args for a WP_Query call.
 * @return WP_Query object
 */
function asa_get_posts( $args = array() ) {

	// Get taxonomies of posts which have a given Level taxonomy.
	$args   = array_merge(
		array(
			'post_type'      => 'study-abroad',
			'posts_per_page' => -1,
		),
		$args
	);
	$fields = get_field( 'study_abroad_search' );
	$level  = $fields['degree_level'];

	if ( $level ) {

		$level             = $level->slug;
		$args['tax_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'level',
				'field'    => 'slug',
				'terms'    => $level,
			),
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

	$id               = 'study-abroad-sidebar-search';
	$sidebar_defaults = apply_filters(
		'genesis_widget_area_defaults',
		array(
			'before'              => genesis_markup(
				array(
					'open'    => '<aside class="study-abroad-search-sidebar widget-area cell small-12 medium-3">' . genesis_sidebar_title( $id ) . '<h2>Filter Programs<a href="#" class="reset-search">Reset</a></h2>',
					'context' => 'widget-area-wrap',
					'echo'    => false,
					'params'  => array(
						'id' => $id,
					),
				)
			),
			'after'               => genesis_markup(
				array(
					'close'   => '</aside>',
					'context' => 'widget-area-wrap',
					'echo'    => false,
				)
			),
			'default'             => '',
			'show_inactive'       => 0,
			'before_sidebar_hook' => 'genesis_before_' . $id . '_widget_area',
			'after_sidebar_hook'  => 'genesis_after_' . $id . '_widget_area',
		),
		'study-abroad-sidebar-search',
		array()
	);

	$output    = $sidebar_defaults['before'];
	$query     = asa_get_posts( array( 'fields' => 'ids' ) );
	$tax_slugs = get_object_taxonomies('study-abroad');
	$post_ids  = $query->posts;
	$tax_terms = array();

	if ( empty( $post_ids ) ) {

		return;

	}

	foreach ($tax_slugs as $slug) {
		$tax_terms[$slug] = get_terms(
			array(
				'taxonomy'   => $slug,
				'object_ids' => $post_ids,
			)
		);
	}

	// Taxonomy search bar output.
	$checkbox = '<li class="item grid-x"><input class="cell shrink %s-%s" type="checkbox" id="dept_%s" value="%s-%s"><label class="cell auto" for="dept_%s">%s</label></li>';
	$output  .= '<ul id="study-abroad-filters" class="reset">';
	foreach ($tax_terms as $key => $value) {
		$meta = get_taxonomy($key);

		$output  .= "<li><h3>{$meta->label}</h3>";
		$output  .= '<ul>';

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
			'aside' => array(
				'class' => array(),
			),
			'ul'    => array(
				'id'    => array(),
				'class' => array(),
			),
			'li'    => array(
				'class' => array(),
			),
			'a'     => array(
				'href'  => array(),
				'class' => array(),
			),
			'div'   => array(
				'class' => array(),
			),
			'h2'    => array(),
			'h3'    => array(),
			'label' => array(
				'class' => array(),
				'for'   => array(),
			),
			'input' => array(
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

	$output     = '<div class="grid-container full"><div class="programs grid-x">';
	$programs   = asa_get_posts();
	$taxonomies = get_object_taxonomies('study-abroad');

	if ( empty( $programs->posts ) ) {

		return;

	}

	// Post list.
	foreach ( $programs->posts as $key => $value ) {
		$terms = wp_get_post_terms( $value->ID, $taxonomies );
		$class = [ 'program', 'cell', 'medium-3', 'small-6' ];
		$link  = get_field( 'study_abroad', $value->ID );
		$thumb = get_the_post_thumbnail( $value->ID, 'medium' );
		$href  = $link ? " href=\"{$link['link']}\"" : '';
		$tag   = $link ? 'a' : 'div';
		foreach ( $terms as $term ) {
			$class[] = "{$term->taxonomy}-{$term->slug}";
		}
		if ( empty( $thumb ) ) {
			$thumb = sprintf(
				'<img alt="Image unavailable" src="%simages/default.svg" style="border:1px solid black;" />',
				AGDPR_DIR_URL
			);
		}
		$open  = sprintf(
			'<%s class="%s"%s>',
			$tag,
			implode( ' ', $class ),
			$href
		);
		$close = "</{$tag}>";

		$output .= sprintf(
			'%s%s<div>%s</div>%s',
			$open,
			$thumb,
			$value->post_title,
			$close
		);
	}

	$output .= '</div></div>';

	// Output.
	echo wp_kses_post( $output );

}

get_header();
genesis();
