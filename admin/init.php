<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\OptionGroup;

add_action( 'admin_enqueue_scripts', function() {

  /**
   * Plugin admin scripts
   *
   * @since 0.0.1
   */
  $scripts = array(
      'jpdevtools-admin' => array(
          'local'     => JPDEVTOOLS_URL . 'assets/js/admin.js',
          'deps'      => array( 'jquery' ),
          'ver'       => '0.0.1',
          'in_footer' => true,
          'autoload'  => true
      ),
  );

  /**
   * Filter plugin admin scripts
   *
   * @since   0.0.1
   * @param   array   $scripts
   */
  $scripts = apply_filters( 'jpdevtools_admin_register_scripts', $scripts );

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

    /* Register admin scripts */
    wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

    if ( $script['autoload'] ) {
      /* Enqueue admin scripts if autolad in enabled */
      wp_enqueue_script( $handle );
    }
  }
} );
