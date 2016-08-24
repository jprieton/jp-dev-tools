<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once __DIR__ . '/class-html.php';
require_once __DIR__ . '/class-form.php';

add_action( 'init', function() {

  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( 'jpwp', false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );
} );
