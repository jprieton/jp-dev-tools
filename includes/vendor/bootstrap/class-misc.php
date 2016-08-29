<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\Html_Helper as Html;

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
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Misc {

  /**
   * Bootstrap close button for modals and/or alerts
   *
   * @since   0.0.1
   *
   * @param   string              $data_dismiss
   * @return  string
   */
  public static function dismiss_button( $data_dismiss ) {
    $span   = HTML::tag( 'span', '&times;', 'aria-hidden=true' );
    $button = HTML::tag( 'button.close', $span, array(
                'type'         => 'button',
                'data-dismiss' => $data_dismiss,
                'aria-label'   => __( 'Close', 'jpwp' )
            ) );
    return $button;
  }

}
