<?php

namespace JPDevTools\Core\Factory;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\SettingGroup;

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
class SettingFactory {

  /**
   * Register a setting group and add filter
   *
   * @since    0.0.1
   *
   * @param    string    $setting_group
   */
  public static function register_setting_group( $setting_group ) {
    $option_group_object = self::setting_group( $setting_group );
    add_action( 'admin_init', array( $option_group_object, 'register_setting' ) );
    add_filter( "pre_update_option_{$setting_group}", array( $option_group_object, 'pre_update_option' ), 10, 2 );
  }

  /**
   * Creates and returns an SettingGroup object
   *
   * @since    0.0.1
   *
   * @param    string    $setting_group
   *
   * @return             SettingGroup
   */
  public static function setting_group( $setting_group ) {
    return new SettingGroup( $setting_group );
  }

}
