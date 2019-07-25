<?php
/**
 * The file that renders single degree program posts
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/templates/single-study-abroad.php
 * @since      0.1.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/templates
 */

add_action( 'genesis_entry_content', 'study_abroad_content' );

/**
 * Provide the post body content.
 *
 * @since 0.1.0
 * @return void
 */
function study_abroad_content() {

	// Echo content.
}

get_header();
genesis();
