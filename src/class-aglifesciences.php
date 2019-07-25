<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-aglifesciences.php
 * @since      0.1.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

/**
 * The core plugin class
 *
 * @since 0.1.0
 * @return void
 */
class Aglifesciences {

	/**
	 * File name
	 *
	 * @var file
	 */
	private static $file = __FILE__;

	/**
	 * Instance
	 *
	 * @var instance
	 */
	private static $instance;

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function __construct() {

		// Require classes.
		$this->require_classes();

		add_action( 'init', array( $this, 'init' ) );

	}

	/**
	 * Init action hook
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function init() {

		$this->register_post_types();

	}

	/**
	 * Initialize the various classes
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function require_classes() {

		/* Set up asset files */
		require_once ALSAF4_DIR_PATH . 'src/class-assets.php';
		$als_assets = new \Aglifesciences\Assets();

		// Add page template custom fields.
		require_once ALSAF4_DIR_PATH . 'src/class-customfields.php';
		new \Aglifesciences\CustomFields();

	}

	/**
	 * Initialize custom post types
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public static function register_post_types() {

		/* Add taxonomies */
		require_once ALSAF4_DIR_PATH . 'src/class-taxonomy.php';
		new \Aglifesciences\Taxonomy( 'Department', 'study-abroad-department', 'study-abroad' );

		/* Add custom post type */
		require_once ALSAF4_DIR_PATH . 'src/class-posttype.php';
		require_once ALSAF4_DIR_PATH . 'src/class-posttemplates.php';
		new \Aglifesciences\PostType(
			array(
				'singular' => 'Study Abroad',
				'plural'   => 'Study Abroad Programs',
			),
			ALSAF4_TEMPLATE_PATH,
			'study-abroad',
			'af4-aglifesciences',
			array(),
			'dashicons-portfolio',
			array( 'title', 'editor', 'thumbnail', 'genesis-seo', 'genesis-scripts' ),
			array( 'single' => 'single-study-abroad.php' )
		);

	}

	/**
	 * Autoloads any classes called within the theme
	 *
	 * @since 0.1.0
	 * @param string $classname The name of the class.
	 * @return void.
	 */
	public static function autoload( $classname ) {

		$filename = dirname( __FILE__ ) .
			DIRECTORY_SEPARATOR .
			str_replace( '_', DIRECTORY_SEPARATOR, $classname ) .
			'.php';

		if ( file_exists( $filename ) ) {
			require $filename;
		}

	}

	/**
	 * Return instance of class
	 *
	 * @since 0.1.0
	 * @return object.
	 */
	public static function get_instance() {

		return null === self::$instance ? new self() : self::$instance;

	}

}
