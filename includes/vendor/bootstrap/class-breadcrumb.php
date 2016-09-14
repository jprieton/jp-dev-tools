<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\HtmlHelper as Html;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Breadcrumb class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.1.0
 * @see            http://getbootstrap.com/components/#breadcrumbs
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Breadcrumb {

  public static function render( $echo = false ) {

    $content = '';

    if ( $echo ) {
      echo $content;
    }

    return $content;
  }

}
