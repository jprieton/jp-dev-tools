<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\HtmlBuilder as Html;
use JPDevTools\Helpers\FormBuilder as Form;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Form_Group class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.1.0
 * @see            http://getbootstrap.com/components/#input-groups
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class FormGroup {

  /**
   * Create a masked file input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   array|string        $attributes
   * @return  string
   */
  public static function file( $name, $label = '', $attributes = array() ) {

    $content = '';
    if ( $label ) {
      $label = Form::label( $name, $label );
    }
    $content .= Form::label( $name, _x( 'Browse...', 'form-field', 'jpdevtools' ), 'class=input-group-addon' );

    $content .= Form::text( $name, '', array(
                'class'       => 'form-control',
                'readonly',
                'placeholder' => __( 'No file selected.', 'jpdevtools' )
            ) );
    $content .= Form::file( $name, wp_parse_args( $attributes, array( 'class' => 'hidden', 'id' => $name ) ) );

    $input_group = Html::tag( 'div.input-group.input-group-file', $content );

    return Html::tag( 'div.form-group', $label . $input_group );
  }

  /**
   * Create a form group input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function input( $type, $name, $value = '', $label = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'value' => $value,
        'type'  => $type,
        'class' => 'form-control'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $content = '';
    if ( $label ) {
      $content .= Form::label( $name, $label );
    }

    $content .= Form::input( $type, $name, $value, $attributes );
    return Html::tag( 'div.form-group', $content );


    return Html::tag( 'input', null, $attributes );
  }

  /**
   * Create a form group text input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function text( $name, $value = '', $label = '', $attributes = array() ) {
    return self::input( 'text', $name, $value, $label, $attributes );
  }

  /**
   * Create a form group email input field.
   *
   * @since 0.1.0
   *
   * @param   string              $name
   * @param   string              $value
   * @param   array|string        $attributes
   * @return  string
   */
  public static function email( $name, $value = '', $label = '', $attributes = array() ) {
    return self::input( 'email', $name, $value, $label, $attributes );
  }

  public static function select( $name, $options = array(), $label = '', $attributes = array() ) {
    $defaults   = array(
        'name'  => $name,
        'class' => 'form-control'
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    $content = '';
    if ( $label ) {
      $content .= Form::label( $name, $label );
    }

    $content .= Form::select( $content, $options, $attributes );
    return $content;
  }

}
