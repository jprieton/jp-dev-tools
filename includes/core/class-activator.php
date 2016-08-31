<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Activation class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class Activator {

  /**
   * The code that runs during plugin activation.
   *
   * @since 0.0.1
   */
  public static function activate() {
    do_action( 'jpdevtools_activation_hook' );
  }

  /**
   * The code that runs during plugin deactivation.
   *
   * @since 0.0.1
   */
  public static function deactivate() {
    do_action( 'jpdevtools_deactivation_hook' );
  }

}
