<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * OptionGroup class
 *
 * @package Core
 * @since 0.1.0
 * @author jprieton
 */
class SettingGroup {

  /**
   * Setting group name
   *
   * @since 0.1.0
   *
   * @var   string
   */
  protected $setting_group = '';

  /**
   * Option data
   *
   * @since   0.1.0
   *
   * @var     array
   */
  protected $options = array();

  /**
   * Constructor
   *
   * @since   0.1.0
   *
   * @param   string    $setting_group
   */
  public function __construct( $setting_group ) {
    $this->setting_group = trim( $setting_group );
    $this->options       = (array) get_option( $this->setting_group, array() );
  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since   0.1.0
   * @return  true
   */
  public function __destruct() {
    return true;
  }

  /**
   * Set option value in group option
   *
   * @since   0.1.0
   *
   * @param   string    $option   Name of option to set. Expected to not be SQL-escaped.
   * @param   mixed     $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
   *
   * @return  bool
   */
  public function set_option( $option, $value ) {
    $this->options[$option] = $value;

    return update_option( $this->setting_group, $this->options );
  }

  /**
   * Get option value in option group.
   *
   * @since   0.1.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   mixed     $default  Optional. Default value to return if the option does not exist.
   *
   * @return  mixed
   */
  public function get_option( $option, $default = false ) {
    $response = isset( $this->options[$option] ) ? $this->options[$option] : $default;

    return $response;
  }

  /**
   * Get boolean option value in option group.
   *
   * @since   0.1.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   boolean   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  boolean
   */
  public function get_bool_option( $option, $default = false ) {
    $value = $this->get_option( $option, $default );

    return (bool) in_array( $value, array( 'Y', 'y', 'yes', 'true', 1 ) );
  }

  /**
   * Get integer option value in option group.
   *
   * @since   0.1.0
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   integer   $default  Optional. Default value to return if the option does not exist.
   *
   * @return  integer
   */
  public function get_int_option( $option, $default = 0 ) {
    return (int) $this->get_option( $option, $default );
  }

  /**
   * Merge options before saving
   *
   * @since   0.1.0
   *
   * @param   array     $new_value
   * @param   array     $old_value
   * @return  array
   */
  public function pre_update_option( $new_value, $old_value ) {
    if ( is_serialized( $new_value ) ) {
      $new_value = unserialize( $new_value );
    }

    $this->options = array_merge( $this->options, (array) $new_value );

    return $this->options;
  }

  /**
   * Register a setting. Must be called in admin_init hook.
   *
   * @since   0.1.0
   */
  public function register_setting() {
    register_setting( $this->setting_group, $this->setting_group );
  }

}
