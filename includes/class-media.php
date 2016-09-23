<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * FavoritePost class
 *
 * @package   Core
 *
 * @since     0.1.0
 * @author    Javier Prieto <jprieton@gmail.com>
 */
class Media {

  /**
   * Returns an array with original image size used in imagecopyresampled
   *
   * @since   0.1.0
   *
   * @param   int            $orig_w
   * @param   int            $orig_h
   * @return  array
   */
  public function image_resize_dimensions_default( $orig_w, $orig_h ) {
    return array( $orig_w, $orig_h, 0, 0, $orig_w, $orig_h, $orig_w, $orig_h );
  }

}
