<?php
/**
 * The file that defines css and js files loaded for the plugin
 *
 * A class definition that includes css and js files used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-assets.php
 * @since      0.8.5
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

namespace Aglifesciences;

/**
 * Add assets
 *
 * @since 0.8.5
 */
class Assets {

	/**
	 * Initialize the class
	 *
	 * @since 0.8.5
	 * @return void
	 */
	public function __construct() {

		// Register global styles used in the theme.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		// Enqueue extension styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

	}

	/**
	 * Registers all styles used within the plugin
	 *
	 * @since 0.8.5
	 * @return void
	 */
	public function register_styles() {

		wp_register_style(
			'aglifesciences-styles',
			ALSAF4_DIR_URL . 'css/aglifesciences.css',
			array( 'college-styles' ),
			filemtime( ALSAF4_DIR_PATH . 'css/aglifesciences.css' ),
			'screen'
		);

	}

	/**
	 * Enqueues extension styles
	 *
	 * @since 0.8.5
	 * @return void
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'aglifesciences-styles' );

	}

}
