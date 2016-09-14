<?php

namespace JPDevTools\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Singleton abstract class
 *
 * @package        Core
 * @subpackage     Abstracts
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
abstract class PostType {

  /**
   * Add action to register post type
   *
   * @since   0.1.0
   */
  public static function register_post_type() {

    // TODO: manage post type options in admin
    $enabled = false;
    if ( $enabled ) {
      add_action( 'post_types_enabled', array( static::class, 'custom_post_type' ) );
    }
  }

  /**
   * @since   0.1.0
   */
  public static function custom_post_type() {

  }

}
