<?php
/**
 * The file that initializes Genesis features and changes for this child theme.
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-genesis.php
 * @since      0.8.5
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

namespace Aglifesciences;

/**
 * Sets up Genesis Framework to our needs
 *
 * @package AgriFlex3
 * @since 0.8.5
 */
class Genesis {

	/**
	 * Initialize the class
	 *
	 * @since 0.8.5
	 * @return void
	 */
	public function __construct() {

		add_filter( 'af4_header_logo', array( $this, 'header_logo' ), 11, 4 );

	}

	/**
	 * Header logo and title
	 *
	 * @since 0.8.5
	 * @param string $inside Current title inner HTML.
	 * @param string $old_inside Previous title inner HTML.
	 * @param string $logo_html HTML template string.
	 * @param string $home Homepage url.
	 * @return string
	 */
	public function header_logo( $inside, $old_inside, $logo_html, $home ) {

		$inside = sprintf(
			'<div class="logo"><a href="%s" title="%s"><img class="logo-long" src="%s" alt="%s"><img class="logo-long-light" src="%s" alt="%s"><img class="logo-break" src="%s" alt="%s"></a></div>',
			$home,
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-long.svg',
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-long-white.svg',
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-break-white.svg',
			get_bloginfo( 'name' )
		);

		return $inside;

	}

}
