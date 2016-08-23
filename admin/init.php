<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'admin_enqueue_scripts', function() {
  wp_enqueue_script( 'jpwp-admin', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '0.0.1', true );
} );
