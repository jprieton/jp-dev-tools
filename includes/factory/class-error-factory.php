<?php

namespace JPDevTools\Core\Factory;

use WP_Error;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * ErrorFactory class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class ErrorFactory {

  /**
   * Shorthand to unauthorized error
   *
   * @since 0.0.1
   *
   * @return WP_Error
   */
  public static function unauthorized( $data = '' ) {
    $error = new WP_Error( 'unauthorized_error', __( 'You are not authorized to perform this action.', JPDEVTOOLS_TEXTDOMAIN ), $data );
    return $error;
  }

  /**
   * Shorthand to logged_out error
   *
   * @since 0.0.1
   *
   * @return WP_Error
   */
  public static function logged_out( $data = '' ) {
    $error = new WP_Error( 'logged_out_error', __( 'You must logged in to perform this action.', JPDEVTOOLS_TEXTDOMAIN ), $data );
    return $error;
  }

}
