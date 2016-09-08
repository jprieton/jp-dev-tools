<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_filter( 'jpdevtools_register_scripts', function($scripts) {
  $scripts['bootstrap'] = array(
      'local'     => JPDEVTOOLS_URL . 'public/js/bootstrap.min.js',
      'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
      'deps'      => array( 'jquery' ),
      'ver'       => '3.3.7',
      'in_footer' => true,
      'autoload'  => false
  );
  return $scripts;
} );

add_action( 'init', function() {

  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-misc.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-alert.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-modal.php';
  require_once plugin_dir_path( __DIR__ ) . 'bootstrap/class-input-group.php';
} );

