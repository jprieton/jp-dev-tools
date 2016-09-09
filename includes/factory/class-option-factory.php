<?php

namespace JPDevTools\Core\Factory;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\OptionGroup;

/**
 * Factory class for OptionGroup
 *
 * @package        Core
 * @subpackage     Factory
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class OptionFactory {

  /**
   * Register an option group settings and add filter
   *
   * @since    0.0.1
   *
   * @param    string    $option_group
   */
  public static function register_option_group( $option_group ) {
    $option_group_object = self::option_group( $option_group );
    add_action( 'admin_init', array( $option_group_object, 'register_setting' ) );
    add_filter( "pre_update_option_{$option_group}", array( $option_group_object, 'pre_update_option' ), 10, 2 );
  }

  /**
   * Creates and returns an OptionGroup object
   *
   * @since    0.0.1
   *
   * @param    string    $option_group
   * 
   * @return             OptionGroup
   */
  public static function option_group( $option_group ) {
    return new OptionGroup( $option_group );
  }

}
