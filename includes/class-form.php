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
   * Retrieve a text input
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
   * Retrieve a textarea input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $text
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function textarea( $name, $text = '', $attributes = array() ) {
    $defaults   = array(
        'name' => $name,
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Html::tag( 'textarea', esc_textarea( $text ), $attributes );
  }

  /**
   * Retrieve a hidden input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function hidden( $name, $value = '', $attributes = array() ) {
    $attributes ['type'] = 'hidden';

    return self::text( $name, $value, $attributes );
  }

  /**
   * Retrieve a email input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function email( $name, $value = '', $attributes = array() ) {
    $attributes ['type'] = 'email';

    return self::text( $name, $value, $attributes );
  }

  /**
   * Retrieve a password input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function password( $name, $attributes = array() ) {
    $attributes ['type'] = 'password';

    return self::text( $name, '', $attributes );
  }

  /**
   * Retrieve a file input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function file( $name, $attributes = array() ) {
    $attributes ['type'] = 'file';

    return self::text( $name, '', $attributes );
  }

  /**
   * Retrieve a label element
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $text
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function label( $name, $text, $attributes = array() ) {
    $attributes ['for'] = $name;

    return HTML::_tag( 'label', $text, $attributes );
  }

  /**
   * Retrieve a button
   *
   * @since 0.0.1
   *
   * @param   string              $text
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function button( $text, $attributes = array() ) {
    $defaults   = array(
        'type' => 'button'
    );
    $attributes = wp_parse_args( $defaults, $attributes );

    return HTML::_tag( 'button', $text, $attributes );
  }

  /**
   * Retrieve a submit button
   *
   * @since 0.0.1
   *
   * @param   string              $text
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function submit( $text = '', $attributes = array() ) {
    $text       = empty( $text ) ? __( 'Send', 'jpwp' ) : $text;
    $defaults   = array(
        'type' => 'submit'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::button( $text, $attributes );
  }

  /**
   * Retrieve a checkbox input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function checkbox( $name, $value, $attributes = array() ) {
    $defaults   = array(
        'type'    => 'checkbox',
        'name'    => $name,
        'value'   => $value,
        'checked' => is_bool( $attributes ) ? $attributes : false
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( $attributes['checked'] ) {
      $attributes['checked'] = 'checked';
    } else {
      unset( $attributes['checked'] );
    }

    return HTML::_tag( 'input', null, $attributes );
  }

  /**
   * Retrieve a radio input
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   string|array        $attributes 
   * @return  string
   */
  public static function radio( $name, $value, $attributes = array() ) {
    $defaults   = array(
        'type'    => 'radio',
        'name'    => $name,
        'value'   => $value,
        'checked' => is_bool( $attributes ) ? $attributes : false
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( $attributes['checked'] ) {
      $attributes['checked'] = 'checked';
    } else {
      unset( $attributes['checked'] );
    }

    return HTML::_tag( 'input', null, $attributes );
  }

  /**
   * Retrieve nonce hidden field and action hidden field for forms.
   * 
   * @since 0.0.1
   * 
   * @param   string              $action
   * @param   string              $name
   * @param   bool                $referer
   * @return  string
   */
  public static function nonce( $action, $name = '_wpnonce', $referer = true ) {
    $field = self::hidden( 'action', $action );
    $field.= wp_nonce_field( $action, $name, $referer, false );

    return $field;
  }

}
