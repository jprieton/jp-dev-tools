<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'init', function() {

  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( 'jpwp', false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );
} );
