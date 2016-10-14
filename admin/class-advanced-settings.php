<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\SettingsPage;
use JPDevTools\Helpers\ArrayHelper;
use WP_Roles;

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
    $this->add_cache_setting_section();
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
          'label' => $post_type->label,
          'value' => $post_type->name,
      );
    }

    $this->add_field( array(
        'name'    => __( 'Erase content', JPDEVTOOLS_TEXTDOMAIN ),
        'type'    => 'checkbox',
        'id'      => 'clean-post-type',
        'options' => $options
    ) );
    add_action( 'pre_update_option_jpdevtools-settings', array( $this, 'pre_update_cleanup' ), 20, 2 );
  }

  /**
   * Delete all post types selected
   *
   * @since   0.1.0
   *
   * @param   array     $new_value
   * @return  array
   */
  public function pre_update_cleanup( $new_value ) {
    $clean_post_type = ArrayHelper::extract( $new_value, 'clean-post-type', array() );

    if ( empty( $clean_post_type ) ) {
      return $new_value;
    }

    $post_types = get_post_types();
    foreach ( $clean_post_type as $post_type ) {
      if ( !in_array( $post_type, $post_types ) ) {
        continue;
      }

      $_posts = get_posts( array( 'post_type' => $post_type, 'posts_per_page' => -1, 'fields' => 'ids', ) );

      foreach ( $_posts as $id ) {
        wp_delete_post( $id, true );
      }
    }
    wp_delete_auto_drafts();
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

    global $wp_roles;

    if ( !isset( $wp_roles ) ) {
      $wp_roles = new WP_Roles();
    }

    $_roles = $wp_roles->get_names();

    $options = array();
    foreach ( $_roles as $key => $label ) {
      $options[] = array(
          'label' => $label,
          'value' => $key,
      );
    }

    $this->add_field( array(
        'name'     => 'Admin Bar Disable',
        'type'     => 'checkbox',
        'id'       => 'admin-bar-disabled',
        'multiple' => true,
        'options'  => $options,
    ) );
  }

  private function add_cache_setting_section() {
    $this->add_setting_section( 'jpdevtools_advanced_settings_section_cache', __( 'Cache', JPDEVTOOLS_TEXTDOMAIN ) );

    $this->add_field( array(
        'name'        => __( 'Favorite Cache', JPDEVTOOLS_TEXTDOMAIN ),
        'id'          => 'favorite-timeout-cache',
        'type'        => 'text',
        'class'       => 'regular-text code',
        'placeholder' => 60 * MINUTE_IN_SECONDS
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
