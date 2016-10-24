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
use JPDevTools\Core\SettingGroup;

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
   * @var SettingGroup
   */
  private $setting_group;

  /**
   * @var mixed
   */
  private $body;

  /**
   * Constructor
   *
   * @since   0.5.0
   */
  protected function __construct() {
    parent::__construct();

    // API settings
    $this->setting_group = SettingFactory::setting_group( 'jpdevtools-settings' );
  }

  /**
   * HTTP API EnvialoSimple member module
   *
   * @since   0.1.0
   * @see     http://envialosimple.com/es/api-http-modulo-member
   *
   * @param   array     $params
   * @return  bool
   */
  public function member( $action, $params ) {
    $response = false;
    switch ( $action ) {
      case 'edit':
        $response = $this->member_edit( $params );
        break;
    }
    return $response;
  }

  /**
   * Add/update contact info
   *
   * @since   0.1.0
   * @see     http://envialosimple.com/es/api-http-modulo-member
   *
   * @param   array     $params
   * @return  bool
   */
  public function member_edit( $params ) {
    // Defaults
    $APIKey       = $this->setting_group->get_option( 'envialosimple-apikey' );
    $MailListID   = $this->setting_group->get_int_option( 'envialosimple-default-list-id', 1 );
    // Params
    $params       = wp_parse_args( $params, compact( 'APIKey', 'MailListID' ) );
    $params       = apply_filters( 'envialosimple-api-params', $params );
    // Request to server
    $raw_response = wp_remote_get( $this->base_url . '/member/edit/format/json', $params );
    // Response
    $this->body   = json_decode( $raw_response['body'] );
    // Successful?
    return (isset( $body->root->ajaxResponse->success ) && $body->root->ajaxResponse->success);
  }

}
