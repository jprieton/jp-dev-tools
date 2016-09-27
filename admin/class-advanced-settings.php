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
    $this->add_security_setting_section();
    $this->add_others_setting_section();
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
   * @return  array
   */
  public function pre_update_cleanup( $new_value ) {
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
        'id'      => 'post-types-enabled',
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
    $this->add_field( array(
        'name'    => __( 'Helpers', JPDEVTOOLS_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'id'      => 'helpers-enabled',
        'options' => array(
            array(
                'id'    => 'frontend-helper-enabled',
                'label' => __( 'Frontend Helper', JPDEVTOOLS_TEXTDOMAIN ),
            ),
        ),
    ) );
  }

  private function add_security_setting_section() {
    $this->add_setting_section( 'jpdevtools_advanced_section_security', __( 'Security', JPDEVTOOLS_TEXTDOMAIN ) );

    $this->add_field( array(
        'name'    => __( 'Header', JPDEVTOOLS_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'id'      => 'security-header',
        'options' => array(
            array(
                'id'    => 'remove-wordpress-version',
                'label' => __( 'Remove WordPress version number', JPDEVTOOLS_TEXTDOMAIN ),
                'desc'  => __( 'Remove WordPress version number from header, feed, styles and scripts.', JPDEVTOOLS_TEXTDOMAIN ),
            ),
            array(
                'id'    => 'remove-rsd-link',
                'label' => __( 'Remove EditURI link', JPDEVTOOLS_TEXTDOMAIN ),
                'desc'  => __( 'Remove the EditURI/RSD link from your header. This option also removes the <b>Windows Live Writer</b> manifest link.', JPDEVTOOLS_TEXTDOMAIN ),
            ),
        ),
    ) );

    $this->add_field( array(
        'name'    => 'XML-RPC',
        'type'    => 'checkbox',
        'id'      => 'security-xmlrcp',
        'options' => array(
            array(
                'id'    => 'xmlrpc-pingback-disabled',
                'label' => 'Disable XML-RPC Pingback',
                'desc'  => __( 'If you uses XML-RPC in your theme/plugins check this for disable only pingback method.', JPDEVTOOLS_TEXTDOMAIN ),
            ),
            array(
                'id'    => 'xmlrpc-pingback-disabled',
                'label' => 'Completely disable XML-RPC',
                'desc'  => __( 'Disable XML-RPC completely. This setting implies the <b>Disable XML-RPC Pingback</b> and <b>Remove EditURI link</b>. <a href="https://www.littlebizzy.com/blog/disable-xml-rpc" target="_blank">More info</a>.', JPDEVTOOLS_TEXTDOMAIN ),
            ),
        ),
    ) );
  }

  private function add_others_setting_section() {
    $this->add_setting_section( 'jpdevtools_advanced_settings_section_others', __( 'Others', JPDEVTOOLS_TEXTDOMAIN ) );

    $this->add_field( array(
        'name'    => 'General',
        'type'    => 'checkbox',
        'options' => array(
            array(
                'id'    => 'cdn-enabled',
                'label' => __( 'Enable CDN', JPDEVTOOLS_TEXTDOMAIN ),
                'desc'  => __( 'Enable use of CDN in local registered scripts and styles.', JPDEVTOOLS_TEXTDOMAIN ),
            ),
        ),
    ) );
  }

}
