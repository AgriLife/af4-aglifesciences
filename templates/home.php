<?php
/**
 * The file that renders the study abroad search page
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/templates/home.php
 * @since      0.4.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/templates
 */

// Force page layout.
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );

// Template CSS.
add_action( 'wp_enqueue_scripts', 'agls_home_styles', 1 );

// Page content.
add_action( 'genesis_entry_content', 'home_content' );

/**
 * Registers and enqueues template styles.
 *
 * @since 0.7.0
 * @return void
 */
function agls_home_styles() {

	wp_register_style(
		'aglifesciences-home',
		ALSAF4_DIR_URL . '/css/home.css',
		array(),
		filemtime( ALSAF4_DIR_PATH . '/css/home.css' ),
		'screen'
	);

	wp_enqueue_style( 'aglifesciences-home' );

}

/**
 * Render the custom fields.
 *
 * @since 0.1.0
 * @return void
 */
function home_content() {

	$fields          = get_field( 'home' );
	$output          = '';
	$output_template = array(
		'image'           => '<div class="image"><img src="%s" alt="%s"></div>',
		'action_items'    => '<div class="action-items grid-container invert"><div class="grid-x grid-padding-x padding-y">%s</div></div>',
		'about_research'  => '<div class="about-research grid-container"><div class="grid-x grid-padding-x"><div class="about cell center-y padding-y medium-6 small-12"><div class="center-y-wrap"><h2>%s</h2>%s<a class="button" href="%s" target="%s">%s</a></div></div><div class="research cell medium-6 small-12"><a href="%s" title="%s"><h3 class="h2"><span class="first-word">Research</span> Stories</h3><div class="excerpt">%s</div>%s</a></div></div></div>',
		'events'          => '<div class="events grid-container invert"><div class="grid-x grid-padding-x padding-y"><h2 class="cell medium-12 small-12">Events</h2>%s</div></div>',
		'livewhale'       => '<div class="livewhale grid-container invert"><div class="grid-x grid-padding-x">%s</div></div>',
		'student_section' => '<div class="student-section grid-container"><div class="grid-x grid-padding-x padding-y"><div class="image arrow-wrap cell medium-4 small-4"><img src="%s" alt="%s"><div class="arrow-right"></div></div><div class="text cell center-y medium-8 small-8"><div class="center-y-wrap"><h2>%s</h2>%s<a class="button" href="%s" target="%s">%s</a></div></div></div></div>',
	);
	$hero_image      = '';
	$action_items    = '';
	$events          = '';
	$livewhale       = '';

	// Top image.
	$output .= sprintf(
		$output_template['image'],
		$fields['top']['url'],
		$fields['top']['alt']
	);

	// Action items.
	foreach ( $fields['action_items'] as $item ) {

		$links = '';

		foreach ( $item['links'] as $link ) {

			$links .= sprintf(
				'<a class="button" href="%s" target="%s">%s</a>',
				$link['link']['url'],
				$link['link']['target'],
				$link['link']['title']
			);

		}

		$action_items .= sprintf(
			'<div class="cell medium-4 small-12"><h2 class="h3 arrow-right">%s</h2><p>%s</p>%s</div>',
			$item['title'],
			$item['subtitle'],
			$links
		);

	}

	$output .= sprintf(
		$output_template['action_items'],
		$action_items
	);

	// About and Research.
	$output .= sprintf(
		$output_template['about_research'],
		$fields['about']['heading'],
		$fields['about']['description'],
		$fields['about']['link']['url'],
		$fields['about']['link']['target'],
		$fields['about']['link']['title'],
		get_post_permalink( $fields['research_stories']['post'] ),
		$fields['research_stories']['post']->post_title,
		$fields['research_stories']['description'],
		get_the_post_thumbnail( $fields['research_stories']['post'], 'large' )
	);

	// Events.
	foreach ( $fields['events'] as $event ) {
		$events .= sprintf(
			'<div class="cell medium-4 small-12"><a href="%s" target="%s">%s<h3 class="arrow-right">%s</h3><div>%s</div></a></div>',
			$event['link']['url'],
			$event['link']['target'],
			wp_get_attachment_image( $event['image'], 'medium_large' ),
			$event['heading'],
			$event['description']
		);
	}

	$output .= sprintf(
		$output_template['events'],
		$events
	);

	// Livewhale.
	$output .= sprintf(
		$output_template['livewhale'],
		$livewhale
	);

	// Student section.
	$output .= sprintf(
		$output_template['student_section'],
		$fields['student_section']['image']['url'],
		$fields['student_section']['image']['alt'],
		$fields['student_section']['heading'],
		$fields['student_section']['content'],
		$fields['student_section']['link']['url'],
		$fields['student_section']['link']['target'],
		$fields['student_section']['link']['title']
	);

	echo wp_kses_post(
		$output
	);

}

get_header();
genesis();
