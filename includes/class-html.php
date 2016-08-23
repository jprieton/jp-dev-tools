<?php

namespace jpwp;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Html class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class Html {

  /**
   * Returns a parsed string for html attributes
   *
   * @since 0.0.1
   *
   * @param array $attributes
   * @return string
   */
  public function parse_attr( $attributes = array() ) {
    $_attr = array();
    foreach ( (array) $attributes as $key => $value ) {
      if ( false === $value ) {
        $_attr[] = trim( $key );
      } elseif ( is_numeric( $key ) ) {
        $_attr[] = trim( $value );
      } else {
        $_attr[] = trim( $key ) . '="' . trim( esc_attr( $value ) ) . '"';
      }
    }
    return implode( ' ', $_attr );
  }

}
