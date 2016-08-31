<?php

namespace JPDevTools\Helpers;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * ArrayHelper class
 *
 * @package        Helpers
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class ArrayHelper {

  /**
   * Removes an item from an array and returns the value.
   *
   * @since 0.0.1
   *
   * @param   array    $array
   * @param   string   $key
   * @param   mixed    $default
   *
   * @return  mixed
   */
  public static function remove( &$array, $key, $default = null ) {
    $response = $default;

    if ( is_array( $array ) && array_key_exists( $key, $array ) ) {
      $response = $array[$key];
      unset( $array[$key] );
    }

    return $response;
  }

}
