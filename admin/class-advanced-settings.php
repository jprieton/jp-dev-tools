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
    $this->add_cleanup_settings_section();
  }

  /**
   * Add cleanup settings section
   *
   * @since   0.1.0
   */
  private function add_cleanup_settings_section() {
    $this->add_setting_section( 'jpdevtools_advanced_settings_section_cleanup', __( 'Cleanup', JPDEVTOOLS_TEXTDOMAIN ) );

    $post_types = get_post_types( array(), 'objects' );
    $options    = array();

    foreach ( $post_types as $post_type ) {
      $options[] = array(
          'id'    => "clean-post-type-{$post_type->name}",
          'label' => $post_type->label,
          'class' => 'clean-post-types dummy-checkbox',
          'name'  => false,
          'value' => $post_type->name,
      );
    }

    $this->add_field( array(
        'name'    => __( 'Erase content', JPDEVTOOLS_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'options' => $options
    ) );
    add_action( 'pre_update_option_jpdevtools-settings', array( $this, 'pre_update_cleanup' ), 20, 2 );
  }

  /**
   * Send all posts in post type to recicle bin
   *
   * @since   0.1.0
   *
   * @param   array     $new_value
   * @param   array     $old_value
   * @return  array
   */
  public function pre_update_cleanup( $new_value, $old_value ) {
    $post_types = get_post_types();
    foreach ( $new_value as $key => $setting ) {
      if ( strpos( $key, 'clean-post-type-' ) === false ) {
        continue;
      }

      if ( $setting == 'no' || !in_array( $setting, $post_types ) ) {
        unset( $new_value[$key] );
        continue;
      }

      $_posts = get_posts( array( 'post_type' => $setting, 'posts_per_page' => -1, 'fields' => 'ids', ) );

      foreach ( $_posts as $id ) {
        wp_delete_post( $id );
      }

      unset( $new_value[$key] );
    }

    return $new_value;
  }

  private function add_development_setting_section() {
    $this->add_setting_section( 'jpdevtools_advanced_settings_section_development', __( 'Development', JPDEVTOOLS_TEXTDOMAIN ) );
    $this->add_field( array(
        'name'    => __( 'Post Type Enabled', JPDEVTOOLS_TEXTDOMAIN ),
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
