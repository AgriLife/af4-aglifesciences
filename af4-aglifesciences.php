<?php
/**
 * Aglifesciences - AgriFlex4
 *
 * @package      af4-aglifesciences
 * @author       Zachary Watkins
 * @copyright    2019 Texas A&M AgriLife Communications
 * @license      GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:  Aglifesciences - AgriFlex4
 * Plugin URI:   https://github.com/AgriLife/af4-aglifesciences
 * Description:  A plugin for The College of Agriculture and Life Sciences' main site on the AgriFlex4 theme.
 * Version:      0.1.0
 * Author:       Zachary Watkins
 * Author URI:   https://github.com/ZachWatkins
 * Author Email: zachary.watkins@ag.tamu.edu
 * Text Domain:  af4-aglifesciences
 * License:      GPL-2.0+
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.txt
 */

/* Define some useful constants */
define( 'ALSAF4_DIRNAME', 'af4-aglifesciences' );
define( 'ALSAF4_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'ALSAF4_DIR_FILE', __FILE__ );
define( 'ALSAF4_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'ALSAF4_TEXTDOMAIN', 'af4-aglifesciences' );

/**
 * The core plugin class that is used to initialize the plugin
 */
require ALSAF4_DIR_PATH . 'src/class-aglifesciences.php';

/* Autoload all classes */
spl_autoload_register( 'Aglifesciences::autoload' );
Aglifesciences::get_instance();
