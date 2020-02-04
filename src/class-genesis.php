<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-genesis.php
 * @since      1.1.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

namespace Aglifesciences;

/**
 * The core plugin class
 *
 * @since 1.1.0
 * @return void
 */
class Genesis {

	/**
	 * Initialize the class
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function __construct() {

		// Replace site title with logo.
		add_filter( 'genesis_seo_title', array( $this, 'add_logo' ), 10, 3 );

		add_action( 'init', array( $this, 'init' ), 13 );

	}

	/**
	 * Init
	 *
	 * @since 1.1.2
	 * @return void
	 */
	public function init() {

		global $afc_genesis;
		remove_filter( 'genesis_markup_title-area_close', array( $afc_genesis, 'college_mobile_nav_toggle' ), 99, 2 );
		add_filter( 'genesis_markup_title-area_open', array( $this, 'college_mobile_nav_toggle' ), 99, 2 );

	}

	/**
	 * Add AgriFlex4 menu and nav primary toggles for mobile
	 *
	 * @since 1.1.2
	 * @param string $output Current output for Genesis title area open element.
	 * @param array  $args Arguments for Genesis title area open element.
	 * @return string
	 */
	public function college_mobile_nav_toggle( $output, $args ) {

		global $af_required;

		$open_m  = str_replace( 'small-6', 'shrink', $af_required->af4_nav_primary_title_bar_open() );
		$open_m  = str_replace( 'title-bar-right', 'title-bar-left', $open_m );
		$menu_m  = $af_required->add_menu_toggle();
		$menu_m  = str_replace( '<div class="title-bar-title" data-toggle="nav-menu-primary">Menu</div>', '', $menu_m );
		$close_m = $af_required->af4_nav_primary_title_bar_close();
		$m       = $open_m . $menu_m . $close_m;

		if ( ! empty( $args['open'] ) && false === strpos( $output, $m ) ) {

			$output = $m . $output;

		}

		return $output;

	}

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @param string $title Genesis SEO title html.
	 * @param string $inside The inner HTML of the title.
	 * @param string $wrap The tag name of the seo title wrap element.
	 * @return string
	 */
	public function add_logo( $title, $inside, $wrap ) {

		$new_inside = sprintf(
			'<div class="logo"><a href="%s" title="%s"><img class="logo-long" src="%s" alt="%s"><img class="logo-long-light" src="%s" alt="%s"><img class="logo-break" src="%s" alt="%s"></a></div>',
			trailingslashit( home_url() ),
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-long.svg',
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-long-white.svg',
			get_bloginfo( 'name' ),
			ALSAF4_DIR_URL . 'images/logo-coals-break-white.svg',
			get_bloginfo( 'name' )
		);

		$title = str_replace( $inside, $new_inside, $title );

		return $title;

	}
}
