<?php
/**
 * The file that defines css and js files loaded for the plugin
 *
 * A class definition that includes css and js files used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-assets.php
 * @since      0.1.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

namespace Aglifesciences;

/**
 * Add assets
 *
 * @package af4-aglifesciences
 * @since 0.1.0
 */
class Assets {

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {

		// Register global styles used in the theme.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );

		// Enqueue extension styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );

		// Register scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ), 11 );

		// Enqueue scripts.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ), 13 );

	}

	/**
	 * Registers all styles used within the plugin
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function register_styles() {

		wp_register_style(
			'aglifesciences-styles',
			ALSAF4_DIR_URL . 'css/aglifesciences.css',
			array(),
			filemtime( ALSAF4_DIR_PATH . 'css/aglifesciences.css' ),
			'screen'
		);

	}

	/**
	 * Enqueues extension styles
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'aglifesciences-styles' );

	}

	/**
	 * Registers scripts
	 *
	 * @since 0.2.0
	 * @return void
	 */
	public function register_scripts() {

		wp_register_script(
			'agrilife-study-abroad',
			ALSAF4_DIR_URL . '/js/study-abroad-search.js',
			array( 'jquery', 'foundation' ),
			filemtime( ALSAF4_DIR_PATH . 'js/study-abroad-search.js' ),
			true
		);

	}

	/**
	 * Enqueues scripts
	 *
	 * @since 0.2.0
	 * @return void
	 */
	public function enqueue_scripts() {

		if ( is_page_template( 'study-abroad-search.php' ) ) {

			wp_enqueue_script( 'agrilife-study-abroad' );

		}

	}

}
