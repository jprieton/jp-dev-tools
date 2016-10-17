<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\SettingsPage;

/**
 * ApiSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.5.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class ApiSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.5.0
   */
  public function __construct() {
    parent::__construct( 'jpdevtools-settings', 'jpdevtools_settings', 'jpdevtools_api_settings' );
    $this->add_submenu_page( __( 'API Settings', JPDEVTOOLS_TEXTDOMAIN ), __( 'API Settings', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_envialosimple_settings_section();
    $this->add_instagram_settings_section();
  }

  /**
   * Add EnvialoSimple settings section
   *
   * @since   0.5.0
   */
  private function add_envialosimple_settings_section() {
    $this->add_setting_section( 'jpdevtools_api_settings_section_envialosimple', 'EnvialoSimple' );
    $this->add_field( array(
        'name'  => __( 'API Key', JPDEVTOOLS_TEXTDOMAIN ),
        'id'    => 'envialosimple-apikey',
        'type'  => 'text',
        'class' => 'large-text code',
    ) );
    $this->add_field( array(
        'name'        => __( 'BaseURL', JPDEVTOOLS_TEXTDOMAIN ),
        'id'          => 'envialosimple-url',
        'type'        => 'text',
        'class'       => 'large-text code',
        'placeholder' => 'https://app.envialosimple.com'
    ) );
  }

  /**
   * Add Instagram API Section
   *
   * @since   0.1.0
   */
  private function add_instagram_settings_section() {
    $this->add_setting_section( 'jpdevtools_api_settings_section_instagram', 'Instagram' );

    $this->add_field( array(
        'name'  => 'Client ID',
        'id'    => 'instagram-client-id',
        'type'  => 'text',
        'class' => 'regular-text code',
    ) );

    $this->add_field( array(
        'name'  => 'Token',
        'id'    => 'instagram-token',
        'type'  => 'text',
        'class' => 'regular-text code',
    ) );

    $this->add_field( array(
        'name'        => __( 'Cache', JPDEVTOOLS_TEXTDOMAIN ),
        'id'          => 'instagram-timeout-cache',
        'type'        => 'text',
        'class'       => 'regular-text code',
        'placeholder' => 60 * MINUTE_IN_SECONDS
    ) );
  }

}
