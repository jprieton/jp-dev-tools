<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'WPINC' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Plugin Name:    JP WordPress Dev Tools
 * Version:        0.0.1
 * Author:         Javier Prieto
 * License:        GPL-3.0+
 * License URI:    http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:    jpwpdt
 * Domain Path:    /languages
 */
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/admin/init.php';
require_once __DIR__ . '/public/init.php';
