<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Register and enqueue public script
   * @since 0.0.1
   */
  wp_enqueue_script( 'jpwp-public', plugin_dir_url( __FILE__ ) . 'js/public.js', array( 'jquery', 'jquery-form' ), '0.0.1', true );

  /**
   * Localize public script
   */
  $localize_script = array(
      'ajax_url' => admin_url( 'admin-ajax.php' ),
      'button'   => array(
          'success' => __( 'Success!', 'jpwp' ),
          'fail'    => __( 'Fail!', 'jpwp' ),
          'error'   => __( 'Error!', 'jpwp' ),
          'send'    => __( 'Send', 'jpwp' ),
          'sent'    => __( 'Sent!', 'jpwp' ),
      )
  );
  wp_localize_script( 'jpwp-public', 'JPDevTools', $localize_script );
} );
