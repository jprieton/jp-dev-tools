<?php

namespace JPDevTools\Helpers;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Array_Helper class
 *
 * @package Helpers
 *
 * @since   0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class ArrayHelper {


  /**
   * Removes an item from an array and returns the value.
   *
   * @since 0.0.1
   *
   * @param   array               $array
   * @param   string              $key
   * @param   mixed               $default
   *
   * @return  mixed
   */
  public static function remove( &$array, $key, $default = null ) {
    if ( is_array( $array ) && (isset( $array[$key] ) || array_key_exists( $key, $array )) ) {
      $value = $array[$key];
      unset( $array[$key] );

      return $value;
    }

    return $default;
  }

}
