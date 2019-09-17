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

		// Load css and js assets.
		new \Aglifesciences\Assets();

		// Add custom fields.
		new \Aglifesciences\CustomFields();

		// Register page templates.
		$this->register_templates();

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
	 * Initialize page templates
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function register_templates() {

		$search = new \Aglifesciences\PageTemplate( ALSAF4_TEMPLATE_PATH, 'study-abroad-search.php', 'Study Abroad Search' );
		$search->register();

	}

	/**
	 * Initialize the various classes
	 *
	 * @since 0.1.0
	 * @return void
	 */
	private function require_classes() {

		// Set up asset files.
		require_once ALSAF4_DIR_PATH . 'src/class-assets.php';

		// Add page templates.
		require_once ALSAF4_DIR_PATH . '/src/class-pagetemplate.php';

		// Add page template custom fields.
		require_once ALSAF4_DIR_PATH . 'src/class-customfields.php';

		// Add post type classes.
		require_once ALSAF4_DIR_PATH . 'src/class-posttype.php';
		require_once ALSAF4_DIR_PATH . 'src/class-posttemplates.php';
		require_once ALSAF4_DIR_PATH . 'src/class-taxonomy.php';

	}

	/**
	 * Initialize custom post types
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public static function register_post_types() {

		/* Add Study Abroad Post Type */
		// Add taxonomies.
		new \Aglifesciences\Taxonomy( 'Department', 'study-abroad-department', 'study-abroad', array( 'rewrite' => array( 'slug' => 'department-sa' ) ) );
		new \Aglifesciences\Taxonomy( 'Region', 'study-abroad-region', 'study-abroad', array( 'rewrite' => array( 'slug' => 'region' ) ) );
		new \Aglifesciences\Taxonomy( 'Term', 'study-abroad-term', 'study-abroad', array( 'rewrite' => array( 'slug' => 'term-sa' ) ) );
		new \Aglifesciences\Taxonomy( 'Program Type', 'study-abroad-program-type', 'study-abroad', array( 'rewrite' => array( 'slug' => 'type' ) ) );
		new \Aglifesciences\Taxonomy( 'Classification', 'study-abroad-classification', 'study-abroad', array( 'rewrite' => array( 'slug' => 'classification' ) ) );

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
			array( 'title', 'editor', 'thumbnail' )
		);
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
