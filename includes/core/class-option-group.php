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
 * @since 0.0.1
 * @author jprieton
 */
class OptionGroup {

  /**
   * Option group name
   *
   * @since 0.0.1
   *
   * @var string
   */
  protected $option_group = '';

  /**
   * Option data
   *
   * @since 0.0.1
   *
   * @var array
   */
  protected $data = array();

  /**
   * Constructor
   *
   * @since   0.0.1
   *
   * @param   string    $option_group
   */
  public function __construct( $option_group ) {

    $this->$option_group = trim( $option_group );
    $this->$data         = (array) get_option( $option_group, array() );

    add_filter( "pre_update_option_{$this->option_group}", array( $this, 'pre_update_option' ), 10, 3 );
  }

  /**
   * Set option value in group option
   *
   * @since   0.0.1
   *
   * @param   string    $option   Name of option to set. Expected to not be SQL-escaped.
   * @param   mixed     $value    Option value. Must be serializable if non-scalar. Expected to not be SQL-escaped.
   *
   * @return  bool
   */
  public function set( $option, $value ) {
    $option                      = trim( (string) $option );
    $this->data[trim( $option )] = $value;

    return update_option( $this->option_group, $this->data );
  }

  /**
   * Get option value in group option.
   *
   * @since   0.0.1
   *
   * @param   string    $option   Name of option to retrieve. Expected to not be SQL-escaped.
   * @param   mixed     $default  Optional. Default value to return if the option does not exist.
   *
   * @return  mixed
   */
  public function get_option( $option, $default = false ) {
    if ( !isset( $this->data[$option] ) ) {
      return $default;
    } else {
      return $this->data[$option];
    }
  }

  /**
   * Filter previous to value in group option.
   *
   * @since   0.0.1
   *
   * @param   array     $value
   * @param   array     $old_value
   * @param   string    $option
   *
   * @return  array
   */
  public function pre_update_option( $value, $old_value, $option ) {
    if ( !is_serialized( $value ) ) {
      $current_option = (array) get_option( $option, array() );
      return array_merge( $current_option, $value );
    } else {
      return unserialize( $value );
    }
  }

  public function register_setting() {
    register_setting( $this->option_group, $this->option_group, array( $this, 'pre_update_option' ) );
  }

}
