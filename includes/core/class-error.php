<?php

namespace JPDevTools\Core;

use WP_Error;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Error class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class Error {

  /**
   * Shorthand to unauthorized error
   *
   * @since 0.0.1
   *
   * @return WP_Error
   */
  public static function unauthorized() {
    $error = new WP_Error( 'unauthorized', __( 'You are not authorized to perform this action ', 'jpdevtools' ) );
    return $error;
  }

}
