<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Core\HTML;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Alert class
 *
 * @package Vendor\Bootstrap
 *
 * @since   0.0.1
 * @see     http://getbootstrap.com/components/#alerts
 *
 * @author  jprieton
 */
class Alert {

  /**
   * Retrieve a Bootstrap alert component
   *
   * @since 0.0.1
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function _alert( $content, $attributes = array() ) {
    $defaults = array(
        'dimissible' => true,
        'role'       => 'alert',
        'class'      => '',
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    // Alert icon span
    $icon = '';
    if ( $attributes['icon'] ) {
      $icon = HTML::_tag( 'span', null, array( 'aria-hidden' => 'true', 'class' => $attributes['icon'] ) );
    }
    unset( $attributes['icon'] );

    // Dimissible button
    $dimissible = '';
    if ( $attributes['dimissible'] ) {
      $_span      = HTML::_tag( 'span', '&times;', 'aria-hidden=true' );
      $dimissible = HTML::_tag( 'button.close', $span, array( 'type' => 'button', 'data-dismiss' => 'alert', 'aria-label' => __( 'Close', 'jpwp' ) ) );

      $attributes['class'] .= ' alert-dismissible';
    }
    unset( $attributes['dimissible'] );

    $attributes['class'] .= ' alert';

    return HTML::_tag( 'div', $icon . $dimissible . $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap success alert component
   *
   * @since 0.0.1
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function success( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-success',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap info alert component
   *
   * @since 0.0.1
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function info( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-info',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap warning alert component
   *
   * @since 0.0.1
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function warning( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-warning',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_alert( $content, $attributes );
  }

  /**
   * Retrieve a Bootstrap danger alert component
   *
   * @since 0.0.1
   *
   * @param   string              $content
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function danger( $content, $attributes = array() ) {
    $defaults   = array(
        'class' => 'alert-danger',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_alert( $content, $attributes );
  }

}
