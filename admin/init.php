<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'admin_enqueue_scripts', function() {

  /**
   * Register and enqueue admin script
   * @since 0.0.1
   */
  wp_enqueue_script( 'jpdevtools-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '0.0.1', true );
} );
