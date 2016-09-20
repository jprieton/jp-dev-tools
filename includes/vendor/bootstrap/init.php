<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'init', function() {

  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-misc.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-alert.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-modal.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-form-group.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-pagination.php';
} );

