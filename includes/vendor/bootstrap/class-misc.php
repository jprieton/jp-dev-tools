<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\HtmlBuilder as Html;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Misc class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Misc {

  /**
   * Bootstrap close button for modals and/or alerts
   *
   * @since   0.1.0
   *
   * @param   string              $data_dismiss
   * @return  string
   */
  public static function dismiss( $data_dismiss ) {
    $span   = HTML::tag( 'span', '&times;', 'aria-hidden=true' );
    $button = HTML::tag( 'button.close', $span, array(
                'type'         => 'button',
                'data-dismiss' => $data_dismiss,
                'aria-label'   => __( 'Close', 'jpdevtools' )
            ) );

    return $button;
  }

  /**
   * Bootstrap badge
   *
   * @since   0.1.0
   *
   * @param   string              $content
   * @return  string
   */
  public static function badge( $content, $attributes = array() ) {

    return Html::tag( 'span.badge', $content, $attributes );
  }

  /**
   * Bootstrap well
   *
   * @since   0.1.0
   *
   * @param   string              $content
   * @return  string
   */
  public static function well( $content, $attributes = array() ) {

    return Html::tag( 'div.well', $content, $attributes );
  }

  /**
   * Bootstrap glyphicon
   *
   * @since   0.1.0
   *
   * @param   string              $glyphicon
   * @return  string
   */
  public static function glyphicon( $glyphicon, $attributes = array() ) {
    $attributes['class']       = $glyphicon;
    $attributes['aria-hidden'] = 'true';
    return Html::tag( 'span.glyphicon ', '', $attributes );
  }

}
