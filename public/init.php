<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once plugin_dir_path( __FILE__ ) . 'class-breadcrumb.php';
require_once plugin_dir_path( __DIR__ ) . 'includes/vendor/bootstrap/init.php';

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Register and enqueue public script
   * @since 0.0.1
   */
  wp_enqueue_script( 'jpdevtools-public', plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery', 'jquery-form' ), '0.0.1', true );

  /**
   * Localize public script
   */
  $localize_script = array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'messages' => array(
          'success' => __( 'Success!', 'jpdevtools' ),
          'fail'    => __( 'Fail!', 'jpdevtools' ),
          'error'   => __( 'Error!', 'jpdevtools' ),
          'send'    => __( 'Send', 'jpdevtools' ),
          'sent'    => __( 'Sent!', 'jpdevtools' ),
      )
  );
  wp_localize_script( 'jpdevtools-public', 'JPDevTools', $localize_script );
} );
