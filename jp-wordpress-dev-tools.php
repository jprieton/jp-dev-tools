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
 * Version:        0.0.1
 * Author:         Javier Prieto
 * License:        GPL-3.0+
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:    jpdevtools
 * Domain Path:    /languages
 *
 * @package Core
 * @since 0.0.1
 */
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/admin/init.php';
require_once __DIR__ . '/public/init.php';

/**
 * The code that runs during plugin activation.
 *
 * @since 0.0.1
 */
register_activation_hook( __FILE__, function() {
  require_once __DIR__ . '/includes/core/class-activator.php';
  JPDevTools\Core\Activator::activate();
} );

/**
 * The code that runs during plugin activation.
 *
 * @since 0.0.1
 */
register_activation_hook( __FILE__, function() {
  require_once __DIR__ . '/includes/core/class-activator.php';
  JPDevTools\Core\Activator::deactivate();
} );
