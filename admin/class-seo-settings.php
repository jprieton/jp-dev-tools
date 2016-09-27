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
 * SeoSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SeoSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    parent::__construct( 'jpdevtools-settings', 'jpdevtools_settings', 'jpdevtools_seo_settings' );
    $this->add_submenu_page( __( 'Analytics &amp; SEO', JPDEVTOOLS_TEXTDOMAIN ), __( 'Analytics &amp; SEO', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_google_settings_section();
    $this->add_bing_settings_section();
    $this->add_facebook_pixel_settings_section();
    $this->add_other_settings_section();
  }

  /**
   * Add Google settings section
   *
   * @since   0.1.0
   */
  private function add_google_settings_section() {
    $this->add_setting_section( 'jpdevtools_seo_settings_section_google', 'Google' );
    $this->add_field( array(
        'name'  => 'Google Universal Analytics',
        'id'    => 'google-universal-analytics',
        'type'  => 'textarea',
        'rows'  => 6,
        'class' => 'large-text code',
    ) );
    $this->add_field( array(
        'name'  => 'Google Tag Manager',
        'id'    => 'google-tag-manager',
        'type'  => 'textarea',
        'rows'  => 6,
        'class' => 'large-text code',
    ) );
    $this->add_field( array(
        'name'  => __( 'Site Verification Code', JPDEVTOOLS_TEXTDOMAIN ),
        'id'    => 'google-site-verification',
        'type'  => 'text',
        'class' => 'large-text code',
        'desc'  => '<code>&lt;meta name="google-site-verification" content="<b>{' . _x( 'verification-code', 'settings', JPDEVTOOLS_TEXTDOMAIN ) . '}</b>"&gt;</code>',
    ) );
  }

  /**
   * Add Bing settings section
   *
   * @since   0.1.0
   */
  private function add_bing_settings_section() {
    $this->add_setting_section( 'jpdevtools_seo_settings_section_bing', 'Bing' );
    $this->add_field( array(
        'name'  => __( 'Site Verification Code', JPDEVTOOLS_TEXTDOMAIN ),
        'id'    => 'bing-site-verification',
        'type'  => 'text',
        'class' => 'large-text code',
        'desc'  => '<code>&lt;meta  name="msvalidate.01" content="<b>{' . _x( 'verification-code', 'settings', JPDEVTOOLS_TEXTDOMAIN ) . '}</b>"&gt;</code>',
    ) );
  }

  /**
   * Add Facebook Pixel Code settings section
   *
   * @since   0.1.0
   */
  private function add_facebook_pixel_settings_section() {
    $this->add_setting_section( 'jpdevtools_seo_settings_section_facebook', 'Facebook' );
    $this->add_field( array(
        'name'  => 'Facebook Pixel Code',
        'id'    => 'facebook-pixel-code',
        'type'  => 'textarea',
        'rows'  => 6,
        'class' => 'large-text code',
    ) );
  }

  private function add_other_settings_section() {
    $this->add_setting_section( 'jpdevtools_seo_settings_section_other', __( 'Others', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_field( array(
        'name'    => 'Meta Tags',
        'type'    => 'checkbox',
        'options' => array(
            array(
                'id'    => 'twitter-card-enabled',
                'label' => 'Twitter Card',
            ),
            array(
                'id'    => 'open-graph-enabled',
                'label' => 'Open Graph',
            ),
        ),
    ) );
  }

}
