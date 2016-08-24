<?php

namespace JPDevTools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Form class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class Form {

  /**
   * Returns a text input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes
   * @return  string
   */
  public static function text( $name, $value = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => 'text'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return HTML::_tag( 'input', null, $attributes );
  }

  /**
   * Returns a hidden input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes
   * @return  string
   */
  public static function hidden( $name, $value = '', $attributes = array() ) {
    $attributes['type'] = 'hidden';
    return self::text( $name, $value, $attributes );
  }

  /**
   * Returns a email input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes
   * @return  string
   */
  public static function email( $name, $value = '', $attributes = array() ) {
    $attributes['type'] = 'email';
    return self::text( $name, $value, $attributes );
  }

  /**
   * Returns a password input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string|array        $attributes
   * @return  string
   */
  public static function password( $name, $attributes = array() ) {
    $attributes['type'] = 'password';
    return self::text( $name, '', $attributes );
  }

  /**
   * Returns a label element
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $text
   * @param   string|array        $attributes
   * @return  string
   */
  public static function label( $name, $text, $attributes = array() ) {
    $attributes['for'] = $name;
    return HTML::_tag( 'label', $text, $attributes );
  }

}
