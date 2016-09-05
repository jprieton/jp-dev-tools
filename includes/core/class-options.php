<?php

namespace JPDevTools\Core;

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\OptionGroup;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Wrapper class for OptionGroup
 *
 * @package        Core
 * @subpackage     Abstracts
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Option extends Singleton {

  private $option_group;

  protected function __construct() {
    $this->option_group = new OptionGroup( 'jpdevtools' );
    add_filter( "pre_update_option_{$this->option_group}", array( $this, 'pre_update_option' ), 10, 3 );
    parent::__construct();
  }

  public function get( $option ) {
    return $this->option_group->get( $option );
  }

  public function set( $option, $value ) {
    return $this->option_group->set( $option, $value );
  }

}
