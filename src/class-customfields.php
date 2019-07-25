<?php
/**
 * The file that loads and handles custom fields
 *
 * @link       https://github.com/AgriLife/af4-aglifesciences/blob/master/src/class-customfields.php
 * @since      0.1.0
 * @package    af4-aglifesciences
 * @subpackage af4-aglifesciences/src
 */

namespace Aglifesciences;

/**
 * The custom fields class
 *
 * @since 0.1.0
 * @return void
 */
class CustomFields {

	/**
	 * Initialize the class
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function __construct() {

		// Add page template custom fields.
		if ( class_exists( 'acf' ) ) {
			require_once ALSAF4_DIR_PATH . 'fields/study-abroad-fields.php';
		}

	}


}
