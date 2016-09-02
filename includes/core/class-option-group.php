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
  protected $opt_group = '';

  /**
   * Option data
   *
   * @since 0.0.1
   *
   * @var array
   */
  protected $options = array();

  /**
   * Constructor
   *
   * @since   0.0.1
   *
   * @param   string    $opt_group
   */
  public function __construct( $opt_group ) {
    $this->opt_group = trim( $opt_group );
    $this->options   = get_option( $opt_group, array() );

    add_filter( "pre_update_option_{$this->opt_group}", array( $this, 'pre_update_option' ), 10, 3 );
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
    $option                         = trim( (string) $option );
    $this->options[trim( $option )] = $value;

    return update_option( $this->opt_group, $this->options );
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
  public function get( $option, $default = false ) {
    if ( !isset( $this->options[$option] ) ) {
      return $default;
    } else {
      return $this->options[$option];
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

}
