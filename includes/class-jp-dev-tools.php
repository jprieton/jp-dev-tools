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

}
