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
 * AdvancedSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class AdvancedSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    parent::__construct( 'jpdevtools-settings', 'jpdevtools_settings', 'jpdevtools_advanced' );
    $this->add_submenu_page( __( 'Advanced', JPDEVTOOLS_TEXTDOMAIN ), __( 'Advanced', JPDEVTOOLS_TEXTDOMAIN ), 'administrator' );
    $this->add_development_setting_section();
  }

  private function add_development_setting_section() {
    $this->add_setting_section( 'jpdevtools_social_settings_section_development', __( 'Development', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_field( array(
        'name'    => __( 'Post Type Enabled' ),
        'type'    => 'checkbox',
        'options' => array(
            array(
                'id'    => 'slide-post-type-enabled',
                'label' => __( 'Carousel', JPDEVTOOLS_TEXTDOMAIN ),
            ),
            array(
                'id'    => 'service-post-type-enabled',
                'label' => __( 'Service', JPDEVTOOLS_TEXTDOMAIN ),
            ),
            array(
                'id'    => 'portfolio-post-type-enabled',
                'label' => __( 'Portfolio', JPDEVTOOLS_TEXTDOMAIN ),
            ),
            array(
                'id'    => 'product-post-type-enabled',
                'label' => __( 'Product', JPDEVTOOLS_TEXTDOMAIN ),
            ),
        ),
    ) );
  }

}
