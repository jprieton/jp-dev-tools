<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Plugin scripts
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

add_action( 'wp_enqueue_scripts', function() {

  /**
   * Plugin scripts
   *
   * @since 0.0.1
   */
  $styles = array(
      'bootstrap'  => array(
          'remote' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
          'ver'    => '3.3.7',
      ),
      'font-awesome'  => array(
          'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
          'ver'    => '4.6.3',
      ),
      'animate'    => array(
          'local'  => JPDEVTOOLS_URL . 'assets/css/animate.min.css',
          'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
          'media'  => 'screen',
          'ver'    => '3.5.2',
      ),
      'jpdevtools' => array(
          'local'    => JPDEVTOOLS_URL . 'assets/css/public.css',
          'ver'      => '0.1.0',
          'autoload' => true
      ),
  );

  /**
   * Filter styles
   *
   * @since   0.0.1
   * @param   array   $styles
   */
  $styles = apply_filters( 'jpdevtools_register_styles', $styles );

  $defaults = array(
      'local'    => '',
      'remote'   => '',
      'deps'     => array(),
      'ver'      => null,
      'media'    => 'all',
      'autoload' => false
  );

  $option_group = new JPDevTools\Core\OptionGroup( 'jpdevtools' );
  $use_cdn      = $option_group->get_bool_option( 'enable-cdn' );

  
  foreach ( $styles as $handle => $style ) {
    $style = wp_parse_args( $style, $defaults );

    if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
      $src = $style['remote'];
    } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
      $src = $style['local'];
    } else {
      continue;
    }

    $deps  = $style['deps'];
    $ver   = $style['ver'];
    $media = $style['media'];

    /* Register styles */
    wp_register_style( $handle, $src, (array) $deps, $ver, $media );

    if ( $style['autoload'] ) {
      /* Enqueue styles if autolad in enabled */
      wp_enqueue_style( $handle );
    }
  }
} );
