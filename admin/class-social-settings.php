<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Settings;

/**
 * SocialSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SocialSettings extends Settings {

  /**
   * Constructor
   *
   * @since   0.0.1
   */
  public function __construct() {
    parent::__construct( 'jpdevtools', 'jpdevtools_settings', 'jpdevtools_social_settings' );
    $this->add_submenu_page( 'Social Networks', 'Social Networks' );
    $this->add_social_links_section();
  }

  private function add_social_links_section() {
    $this->add_setting_section( 'jpdevtools_social_settings_section_links', __( 'Social Links', 'jpdevtools' ) );

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
    $social_networks = apply_filters( 'jpdevtools_social_neworks', $social_networks );

    foreach ( $social_networks as $key => $label ) {
      $this->add_field( array(
          'name'  => $label,
          'id'    => $key,
          'type'  => 'text',
          'class' => 'regular-text code',
      ) );
    }
  }

}
