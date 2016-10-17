<?php

namespace JPDevTools\Api;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\Factory\SettingFactory;

/**
 * EnvialoSimpleApi class
 *
 * @package        API
 *
 * @since          0.5.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class EnvialoSimpleApi extends Singleton {

  /**
   * @var EnvialoSimpleApi
   */
  static $instance;

  /**
   * @var string API Key
   */
  private $apikey;

  /**
   * Constructor
   *
   * @since   0.5.0
   */
  protected function __construct() {
    parent::__construct();

    // API settings
    $setting_group = SettingFactory::setting_group( 'jpdevtools-settings' );
    $this->apikey  = $setting_group->get_option( 'envialosimple-apikey' );
  }

}
