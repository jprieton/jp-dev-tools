<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Plugin admin scripts
   *
   * @since 0.0.1
   */
  $scripts = array(
      'bootstrap'  => array(
          'local'     => JPDEVTOOLS_URL . 'assets/js/bootstrap.min.js',
          'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
          'deps'      => array( 'jquery' ),
          'ver'       => '3.3.7',
          'in_footer' => true,
          'autoload'  => false
      ),
      'jpdevtools' => array(
          'local'     => JPDEVTOOLS_URL . 'assets/js/public.js',
          'deps'      => array( 'jquery' ),
          'ver'       => '0.0.1',
          'in_footer' => true,
          'autoload'  => true
      ),
      'modernizr'  => array(
          'local'    => JPDEVTOOLS_URL . 'assets/js/modernizr.min.js',
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

  $option_group = new JPDevTools\Core\OptionGroup( 'jpdevtools' );
  $use_cdn      = $option_group->get_bool_option( 'enable-cdn' );

  foreach ( $scripts as $handle => $script ) {
    $script = wp_parse_args( $script, $defaults );

    if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
      $src = $script['remote'];
    } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
      $src = $script['local'];
    } else {
      continue;
    }

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
