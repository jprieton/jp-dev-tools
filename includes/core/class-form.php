<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Form class
 *
 * Based on Laravel Forms & HTML
 *
 * @package Core
 *
 * @since   0.0.1
 * @see     https://laravelcollective.com/docs/master/html
 *
 * @author  jprieton
 */
class Form {

  /**
   * Open up a new HTML form.
   *
   * @since 0.0.1
   *
   * @param   array|string        $attributes
   *
   * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
   *
   * @return  string
   */
  public static function open( $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );
    $attributes = HTML::_attributes( $attributes );

    return sprintf( '<%s>', trim( 'form ' . $attributes ) );
  }

  /**
   * Close the HTML form.
   *
   * @since 0.0.1
   *
   * @return  string
   */
  public static function close() {
    return '</form>';
  }

  /**
   * Create a form input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function input( $type, $name, $value = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => $type
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return HTML::_tag( 'input', null, $attributes );
  }

  /**
   * Create a text input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function text( $name, $value = '', $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'text', $name, $value, $attributes );
  }

  /**
   * Create a textarea input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $text
   * @param   array|string        $attributes
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
   * Create a hidden input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function hidden( $name, $value = '', $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'hidden', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function email( $name, $value = '', $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'email', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function url( $name, $value = '', $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'url', $name, $value, $attributes );
  }

  /**
   * Create a password input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public static function password( $name, $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'password', $name, null, $attributes );
  }

  /**
   * Create a file input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public static function file( $name, $attributes = array() ) {
    $defaults   = array();
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::input( 'file', $name, null, $attributes );
  }

  /**
   * Create a label element field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function label( $name, $text, $attributes = array() ) {
    $attributes ['for'] = $name;

    return HTML::_tag( 'label', $text, $attributes );
  }

  /**
   * Create a button
   *
   * @since 0.0.1
   *
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function button( $text, $attributes = array() ) {
    $defaults   = array(
        'type' => 'button'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return HTML::_tag( 'button', $text, $attributes );
  }

  /**
   * Create a submit button
   *
   * @since 0.0.1
   *
   * @param   string              $text
   * @param   array|string        $attributes
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
   * Create a checkbox input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function checkbox( $name, $value, $attributes = array() ) {
    $defaults   = array(
        'checked' => is_bool( $attributes ) ? $attributes : false
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( $attributes['checked'] ) {
      $attributes['checked'] = 'checked';
    } else {
      unset( $attributes['checked'] );
    }

    return self::input( 'checkbox', $name, $value, $attributes );
  }

  /**
   * Create a radio input field.
   *
   * @since 0.0.1
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function radio( $name, $value, $attributes = array() ) {
    $defaults   = array(
        'checked' => is_bool( $attributes ) ? $attributes : false
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    if ( $attributes['checked'] ) {
      $attributes['checked'] = 'checked';
    } else {
      unset( $attributes['checked'] );
    }

    return self::input( 'radio', $name, $value, $attributes );
  }

  /**
   * Create a nonce hidden field and action hidden field for forms.
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
    $field .= wp_nonce_field( $action, $name, $referer, false );

    return $field;
  }

}
