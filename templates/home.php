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

// Remove unneeded hooks.
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );

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
		ALSAF4_DIR_URL . 'css/home.css',
		array(),
		filemtime( ALSAF4_DIR_PATH . 'css/home.css' ),
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
		'image'           => '<div class="alignfull no-padding top">%s</div>',
		'action_items'    => '<div class="alignfull invert action-items"><div class="grid-container"><div class="grid-x grid-padding-x padding-y">%s</div></div></div>',
		'about_research'  => '<div class="alignfull no-padding about-research"><div class="grid-container"><div class="grid-x grid-padding-x"><div class="about cell center-y padding-y medium-6 small-12"><div class="center-y-wrap"><h2>%s</h2>%s<a class="button" href="%s" target="%s">%s</a></div></div><div class="research cell medium-6 small-12"><a href="%s"><h3 class="h2"><span class="first-word">Research</span> Stories</h3>%s<div class="excerpt">%s</div></a></div></div></div></div>',
		'events'          => '<div class="alignfull events invert"><div class="grid-container"><div class="grid-x grid-padding-x padding-y"><h2 class="cell medium-12 small-12">Events</h2>%s</div></div></div>',
		'livewhale'       => '<div class="alignfull livewhale invert"><div class="grid-container"><div class="grid-x grid-padding-x padding-y"><div class="events-cell cell medium-auto small-12 grid-container"><div class="grid-x grid-padding-x">%s</div></div><div class="events-all cell medium-shrink small-12"><a class="h3 arrow-right" href="#">All Events</a></div></div></div></div>',
		'student_section' => '<div class="alignfull student-section"><div class="grid-container"><div class="grid-x grid-padding-x padding-y"><div class="image arrow-wrap cell medium-4">%s<div class="arrow-right hide-for-small-only"></div></div><div class="text cell center-y medium-8 small-12"><div class="center-y-wrap"><h2>%s</h2><div class="statement">%s</div><a class="button" href="%s" target="%s">%s</a></div></div></div></div></div>',
	);

	// Top image.
	$output .= sprintf(
		$output_template['image'],
		$fields['top']
	);

	// Action items.
	if ( $fields['action_items'] ) {

		$action_items = '';

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

	}

	// About and Research.
	$research_story_image = wp_get_attachment_image( $fields['research_stories']['image'], 'large' );
	$output              .= sprintf(
		$output_template['about_research'],
		$fields['about']['heading'],
		$fields['about']['description'],
		$fields['about']['link']['url'],
		$fields['about']['link']['target'],
		$fields['about']['link']['title'],
		$fields['research_stories']['link']['url'],
		$research_story_image,
		$fields['research_stories']['description']
	);

	// Events.
	if ( $fields['events'] ) {

		$events = '';

		foreach ( $fields['events'] as $event ) {

			$events .= sprintf(
				'<div class="cell medium-4 small-12"><a href="%s" target="%s">%s<h3 class="arrow-right small-order-1">%s</h3><div class="small-order-2">%s</div></a></div>',
				$event['link']['url'],
				$event['link']['target'],
				wp_get_attachment_image( $event['image'], 'medium_large', false, array( 'class' => 'small-order-3 attachment-medium_large size-medium_large' ) ),
				$event['heading'],
				$event['description']
			);

		}

		$output .= sprintf(
			$output_template['events'],
			$events
		);

	}

	// Livewhale.
	$feed_json    = wp_remote_get( 'https://calendar.tamu.edu/live/json/events/group/College%20of%20Agriculture%20and%20Life%20Sciences/only_starred/true/' );
	$feed_array   = json_decode( $feed_json['body'], true );
	$l_events     = array_slice( $feed_array, 0, 3 ); // Choose number of events.
	$l_event_list = '';

	foreach ( $l_events as $event ) {

		$title      = $event['title'];
		$url        = $event['url'];
		$location   = $event['location'];
		$date       = $event['date_utc'];
		$time       = $event['date_time'];
		$date       = date_create( $date );
		$date_day   = date_format( $date, 'd' );
		$date_month = date_format( $date, 'M' );

		if ( array_key_exists( 'custom_room_number', $event ) && ! empty( $event['custom_room_number'] ) ) {

			$location = $event['custom_room_number'];

		}

		$l_event_list .= sprintf(
			'<div class="event cell medium-auto small-12"><div class="grid-x grid-padding-x"><div class="cell date shrink"><div class="month h3">%s</div><div class="h2 day">%s</div></div><div class="cell title auto"><a href="%s" title="%s" class="event-title medium-truncate-lines medium-truncate-2-lines">%s</a><div class="location medium-truncate-lines medium-truncate-2-lines">%s</div></div></div></div>',
			$date_month,
			$date_day,
			$url,
			$title,
			$title,
			$location
		);

	}

	$output .= sprintf(
		$output_template['livewhale'],
		$l_event_list
	);

	// Student section.
	$student_image_id = $fields['student_section']['image'];
	$output          .= sprintf(
		$output_template['student_section'],
		wp_get_attachment_image( $student_image_id, 'medium_large' ),
		$fields['student_section']['heading'],
		$fields['student_section']['content'],
		$fields['student_section']['link']['url'],
		$fields['student_section']['link']['target'],
		$fields['student_section']['link']['title']
	);

	echo wp_kses_post( $output );

}

get_header();
genesis();
