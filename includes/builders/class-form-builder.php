<?php

namespace JPDevTools\Helpers;

use JPDevTools\Helpers\HtmlBuilder;
use JPDevTools\Helpers\ArrayHelper;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * FormBuilder class
 *
 * Based on Laravel Forms & HTML
 *
 * @package Core
 *
 * @since   0.1.0
 * @see     https://laravelcollective.com/docs/master/html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class FormBuilder {

  /**
   * Open up a new HTML form.
   *
   * @since 0.1.0
   *
   * @param   array|string        $attributes
   *
   * @see     https://developer.mozilla.org/en-US/docs/Web/HTML/Element/form
   *
   * @return  string
   */
  public static function open( $attributes = array() ) {
    return '<form ' . HtmlBuilder::attributes( $attributes ) . '>';
  }

  /**
   * Close the HTML form.
   *
   * @since 0.1.0
   *
   * @return  string
   */
  public static function close() {
    return '</form>';
  }

  /**
   * Create a form input field.
   *
   * @since 0.1.0
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

    return '<input ' . HtmlBuilder::attributes( $attributes ) . '>';
  }

  /**
   * Create a text input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function text( $name, $value = '', $attributes = array() ) {
    return self::input( 'text', $name, $value, $attributes );
  }

  /**
   * Create a textarea input field.
   *
   * @since 0.1.0
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

    return HtmlBuilder::tag( 'textarea', esc_textarea( $text ), $attributes );
  }

  /**
   * Create a hidden input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function hidden( $name, $value = '', $attributes = array() ) {
    return self::input( 'hidden', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function email( $name, $value = '', $attributes = array() ) {
    return self::input( 'email', $name, $value, $attributes );
  }

  /**
   * Create a email input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function url( $name, $value = '', $attributes = array() ) {
    return self::input( 'url', $name, $value, $attributes );
  }

  /**
   * Create a password input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public static function password( $name, $attributes = array() ) {
    return self::input( 'password', $name, null, $attributes );
  }

  /**
   * Create a file input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public static function file( $name, $attributes = array() ) {
    return self::input( 'file', $name, null, $attributes );
  }

  /**
   * Create a label element field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function label( $name, $text, $attributes = array() ) {
    $attributes = wp_parse_args( $attributes, array( 'for' => $name ) );
    return HtmlBuilder::tag( 'label', $text, $attributes );
  }

  /**
   * Create a button
   *
   * @since 0.1.0
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

    return HtmlBuilder::tag( 'button', $text, $attributes );
  }

  /**
   * Create a submit button
   *
   * @since 0.1.0
   *
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function submit( $text = '', $attributes = array() ) {
    $text       = empty( $text ) ? __( 'Submit', 'jpdevtools' ) : $text;
    $defaults   = array(
        'type' => 'submit'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::button( $text, $attributes );
  }

  /**
   * Create a reset button
   *
   * @since 0.1.0
   *
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function reset( $text = '', $attributes = array() ) {
    $text       = empty( $text ) ? __( 'Reset', 'jpdevtools' ) : $text;
    $defaults   = array(
        'type' => 'reset'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::button( $text, $attributes );
  }

  /**
   * Create a checkbox input field.
   *
   * @since 0.1.0
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
   * @since 0.1.0
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
   * Create a action hidden field and nonce hidden field for forms.
   *
   * @since 0.1.0
   *
   * @param   string              $action
   * @param   string              $name
   * @param   bool                $referer
   * @return  string
   */
  public static function action_nonce( $action, $name = '_wpnonce', $referer = true ) {
    $field = self::hidden( 'action', $action );
    $field .= wp_nonce_field( $action, $name, $referer, false );

    return $field;
  }

  /**
   * Create a dropdown list.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   array|string        $options
   * @param   array|string        $attributes
   * @return  string
   */
  public static function select( $name, $options, $attributes = array() ) {
    global $wp_locale;

    $content = '';

    switch ( $options ) {
      case 'month':
        $options = $wp_locale->month;
        break;
      case 'weekday':
        $options = $wp_locale->weekday;
        break;
      default:
        $options = (is_array( $options )) ? $options : (array) $options;
        break;
    }

    $attributes = wp_parse_args( $attributes, compact( 'name' ) );

    $use_label = ArrayHelper::extract( $attributes, 'use_label', false );
    if ( $use_label ) {
      $options = array_combine( $options, $options );
    }

    $placeholder = ArrayHelper::extract( $attributes, 'placeholder', false );

    if ( is_bool( $placeholder ) && $placeholder ) {
      $content .= HtmlBuilder::tag( 'option', _e( 'Select an option...', 'jpdevtools' ), array( 'value' => '' ) );
    } elseif ( !is_bool( $placeholder ) && $placeholder ) {
      $content .= HtmlBuilder::tag( 'option', $placeholder, array( 'value' => '' ) );
    }

    $selected = ArrayHelper::extract( $attributes, 'selected', '' );
    $content  .= self::options( $options, $selected );

    return HtmlBuilder::tag( 'select', $content, $attributes );
  }

  /**
   * Create a datalist tag.
   *
   * @since 0.1.0
   *
   * @param   array|string        $options
   * @param   array|string        $attributes
   * @return  string
   */
  public static function datalist( $options, $attributes = array() ) {
    global $wp_locale;

    $content = '';

    switch ( $options ) {
      case 'month':
        $options = $wp_locale->month;
        break;
      case 'weekday':
        $options = $wp_locale->weekday;
        break;
      default:
        $options = (is_array( $options )) ? $options : (array) $options;
        break;
    }

    foreach ( $options as $value ) {
      $content .= HtmlBuilder::tag( 'option', '', compact( 'value' ) );
    }

    return HtmlBuilder::tag( 'datalist', $content, $attributes );
  }

  /**
   * Create a list of option tags from array .
   *
   * @param   array               $options
   * @param   string              $selected
   */
  public static function options( $options, $selected = '' ) {
    $content = '';

    foreach ( $options as $key => $value ) {
      if ( is_array( $value ) ) {
        $content .= HtmlBuilder::tag( 'optgroup', self::options( $value, $selected ), array( 'label' => $key ) );
      } else {
        $attributes = array(
            'value'    => $value,
            'selected' => ($selected == $value)
        );
        $content    .= HtmlBuilder::tag( 'option', $key, $attributes );
      }
    }
    return $content;
  }

}
