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
 * InstagramApi class
 *
 * @package        API
 *
 * @since          0.5.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class InstagramApi extends Singleton {

  /**
   * @var type EnvialoSimpleApi
   */
  static $instance;

  /**
   * @var string ClientID
   */
  static $client_id;

  /**
   * @var string Token
   */
  static $token;

  /**
   * @var int Cache timeout
   */
  static $timeout;

  /**
   * Constructor
   *
   * @since   0.5.0
   *
   * @return  static
   */
  protected function __construct() {
    parent::__construct();

    // API settings
    $setting_group     = SettingFactory::setting_group( 'jpdevtools-settings' );
    static::$client_id = $setting_group->get_option( 'instagram-client-id' );
    static::$token     = $setting_group->get_option( 'instagram-token' );
    static::$timeout   = $setting_group->get_int_option( 'instagram-timeout-cache', 60 * MINUTE_IN_SECONDS );
  }

}
