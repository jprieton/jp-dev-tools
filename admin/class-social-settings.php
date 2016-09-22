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
 * SocialSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SocialSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    parent::__construct( 'jpdevtools-settings', 'jpdevtools_settings', 'jpdevtools_social_settings' );
    $this->add_submenu_page( __( 'Social Networks', JPDEVTOOLS_TEXTDOMAIN ), __( 'Social Networks', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_social_links_section();
    $this->add_facebook_section();
    $this->add_instagram_section();
  }

  /**
   * Add social network links
   *
   * @since   0.1.0
   */
  private function add_social_links_section() {
    $this->add_setting_section( 'jpdevtools_social_settings_section_links', __( 'Links', JPDEVTOOLS_TEXTDOMAIN ) );

    /** Default networks */
    $social_networks = array(
        'social-facebook'    => 'Facebook',
        'social-dribbble'    => 'Dribble',
        'social-google-plus' => 'Google+',
        'social-instagram'   => 'Instagram',
        'social-linkedin'    => 'LinkedIn',
        'social-pinterest'   => 'Pinterest',
        'social-rss'         => 'RSS',
        'social-twitter'     => 'Twitter',
        'social-yelp'        => 'Yelp',
        'social-youtube'     => 'YouTube',
    );

    /** Filter to add more networks */
    $social_networks = apply_filters( 'jpdevtools_social_networks', $social_networks );

    foreach ( $social_networks as $key => $label ) {
      $this->add_field( array(
          'name'  => $label,
          'id'    => $key,
          'type'  => 'text',
          'class' => 'regular-text code',
      ) );
    }
  }

  /**
   * Add Facebook API Section
   *
   * @since   0.1.0
   */
  private function add_facebook_section() {
    $this->add_setting_section( 'jpdevtools_social_settings_section_facebook', __( 'Facebook', JPDEVTOOLS_TEXTDOMAIN ) );

    $fields = array(
        'facebook-app-id' => 'App ID',
        'facebook-admins' => 'Admin IDs',
    );

    foreach ( $fields as $key => $label ) {
      $this->add_field( array(
          'name'  => $label,
          'id'    => $key,
          'type'  => 'text',
          'class' => 'regular-text code',
      ) );
    }
  }

  /**
   * Add Instagram API Section
   *
   * @since   0.1.0
   */
  private function add_instagram_section() {
    $this->add_setting_section( 'jpdevtools_social_settings_section_instagram', __( 'Instagram', JPDEVTOOLS_TEXTDOMAIN ) );

    $fields = array(
        'instagram-client-id' => 'Client ID',
        'instagram-token'     => 'Token',
    );

    foreach ( $fields as $key => $label ) {
      $this->add_field( array(
          'name'  => $label,
          'id'    => $key,
          'type'  => 'text',
          'class' => 'regular-text code',
      ) );
    }
  }

}
