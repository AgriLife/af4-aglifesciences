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

		// Add Department navigation menu.
		add_filter( 'wp_nav_menu_items', array( $this, 'add_department_nav_menu' ), 10, 2 );

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

	/**
	 * Add the Department navigation menu to the site header.
	 *
	 * @since 1.4.0
	 * @param string   $items  The HTML list content for the menu items.
	 * @param stdClass $args An object containing wp_nav_menu() arguments.
	 * @return string
	 */
	public function add_department_nav_menu( $items, $args ) {

		if (
			'primary' === $args->theme_location &&
			false === strpos( $items, 'dept-nav' ) &&
			has_nav_menu( 'college-dept-menu' )
		) {

			$menu      = array(
				'theme_location' => 'college-dept-menu',
				'menu_class'     => 'menu submenu sub-menu vertical medium-horizontal menu-depth-1 first-sub',
				'container'      => '',
			);
			$dept_item = '<li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children unlinked dept-nav" role="menuitem" aria-haspopup="true" aria-label="Departments"><a href="#" itemprop="url">Departments</a>%s</li>';

			ob_start();
			wp_nav_menu( $menu );
			$depnav = ob_get_contents();
			ob_end_clean();

			$deptmenu = sprintf( $dept_item, $depnav );

			// Convert menu item string to array.
			$items_array = array();
			$item_pos    = strpos( $items, '<li', 10 );
			while ( false !== $item_pos ) {
				$items_array[] = substr( $items, 0, $item_pos );
				$items         = substr( $items, $item_pos );
				$item_pos      = strpos( $items, '<li', 10 );
			}
			$items_array[] = $items;

			if ( false !== strpos( $items_array[0], trailingslashit( home_url() ) ) ) {
				// The first nav menu item is Home; insert the item after it.
				array_splice( $items_array, 1, 0, $deptmenu );
			} else {
				// Insert it at the beginning of the menu.
				array_unshift( $items_array, $deptmenu );
			}

			// Convert menu item array to string.
			$items = implode( '', $items_array );

		}

		return $items;

	}
}
