<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Plugin Name:    JP WordPress Dev Tools
 * Description:
 * Version:        0.1.0
 * Author:         Javier Prieto
 * License:        GPL-3.0+
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:    jpdevtools
 * Domain Path:    /languages
 *
 * @package Core
 * @since 0.1.0
 */
define( 'JPDEVTOOLS_DIR', __DIR__ );
define( 'JPDEVTOOLS_FILE', __FILE__ );
define( 'JPDEVTOOLS_URL', plugin_dir_url( __FILE__ ) );
define( 'JPDEVTOOLS_TEXTDOMAIN', 'jpdevtools' );

/**
 * Disable the Plugin and Theme Editor
 * @since 0.1.0
 */
defined( 'DISALLOW_FILE_EDIT' ) || define( 'DISALLOW_FILE_EDIT', true );

require_once JPDEVTOOLS_DIR . '/includes/init.php';
require_once JPDEVTOOLS_DIR . '/admin/init.php';
require_once JPDEVTOOLS_DIR . '/public/init.php';

/**
 * The code that runs during plugin activation.
 * @since 0.1.0
 */
register_activation_hook( __FILE__, function() {
  require_once JPDEVTOOLS_DIR . '/includes/core/class-activator.php';
  JPDevTools\Core\Activator::activate();
} );

/**
 * The code that runs during plugin activation.
 * @since 0.1.0
 */
register_activation_hook( __FILE__, function() {
  require_once JPDEVTOOLS_DIR . '/includes/core/class-activator.php';
  JPDevTools\Core\Activator::deactivate();
} );
