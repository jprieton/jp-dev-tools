<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\Html_Helper as Html;
use JPDevTools\Vendor\Bootstrap\Misc;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Alert class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.0.1
 * @see            http://getbootstrap.com/components/#alerts
 *
 * @author         Javier Prieto <jprieton@gmail.com>
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
        'dismiss' => true,
        'role'    => 'alert',
        'class'   => '',
        'icon'    => '',
    );

    $attributes = wp_parse_args( $attributes, $defaults );

    // Alert icon span
    $icon = '';
    if ( $attributes['icon'] ) {
      $icon = Html::tag( 'span', null, array( 'aria-hidden' => 'true', 'class' => $attributes['icon'] ) );
    }
    unset( $attributes['icon'] );

    // Dimissible button
    $dismiss = '';
    if ( $attributes['dismiss'] ) {
      $dismiss = Misc::dismiss_button( 'modal' );
    }
    unset( $attributes['dismiss'] );

    $attributes['class'] .= ' alert';

    return Html::tag( 'div', $icon . $dismiss . $content, $attributes );
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
