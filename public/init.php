<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once plugin_dir_path( __FILE__ ) . 'class-breadcrumb.php';
require_once plugin_dir_path( __DIR__ ) . 'includes/vendor/bootstrap/init.php';

use JPDevTools\Core\OptionGroup;

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Plugin admin scripts
   *
   * @since 0.0.1
   */
  $scripts = array(
      'jpdevtools' => array(
          'handle'    => 'jpdevtools',
          'local'     => plugin_dir_url( __FILE__ ) . 'js/public.js',
          'deps'      => array( 'jquery' ),
          'ver'       => '0.0.1',
          'in_footer' => true,
          'autoload'  => true
      ),
      'modernizr'  => array(
          'handle'   => 'modernizr',
          'local'    => plugin_dir_url( __FILE__ ) . 'js/modernizr.min.js',
          'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
          'ver'      => '2.8.3',
          'autoload' => true
      ),
  );
  /**
   * Filter plugin scripts
   *
   * @since   0.0.1
   * @param   array   $scripts
   */
  $scripts = apply_filters( 'jpdevtools_register_scripts', $scripts );

  $defaults = array(
      'local'     => '',
      'remote'    => '',
      'deps'      => array(),
      'ver'       => null,
      'in_footer' => false,
      'autoload'  => false
  );

  $options = new OptionGroup( 'jpdevtools' );
  $use_cdn = ($options->get_option( 'enable-cdn', false ) == 'yes');

  foreach ( $scripts as $script ) {
    $script = wp_parse_args( $script, $defaults );

    if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
      $src = $script['remote'];
    } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
      $src = $script['local'];
    } else {
      continue;
    }

    $handle    = $script['handle'];
    $deps      = $script['deps'];
    $ver       = $script['ver'];
    $in_footer = $script['in_footer'];

    /* Register scripts */
    wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

    if ( $script['autoload'] ) {
      /* Enqueue scripts if autolad in enabled */
      wp_enqueue_script( $handle );
    }
  }

  /**
   * Localize public script
   *
   * @since   0.0.1
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

  /**
   * Filter localize scripts
   *
   * @since   0.0.1
   * @param   array   $localize_script
   */
  $localize_script = apply_filters( 'jpdevtools_localize_scripts', $localize_script );

  wp_localize_script( 'jpdevtools', 'JPDevTools', $localize_script );
} );
