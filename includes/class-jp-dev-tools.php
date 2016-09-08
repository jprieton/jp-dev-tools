<?php

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\OptionGroup;

/**
 *
 */
class JPDevTools extends Singleton {

  public $option_group;

  protected function __construct() {
    $this->option_group = new OptionGroup( 'jpdevtools' );
    parent::__construct();
  }

  /**
   * Add filter to parse options
   *
   * @since   0.0.1
   */
  public function pre_update_option() {
    add_filter( "pre_update_option_jpdevtools", array( $this->option_group, 'pre_update_option' ), 10, 2 );
  }

}
