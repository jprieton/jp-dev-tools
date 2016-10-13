<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once JPDEVTOOLS_DIR . '/admin/class-admin-init.php';

use JPDevTools\Core\Init\AdminInit;

add_action( 'admin_menu', function () {

  $init = AdminInit::get_instance();

  /**
   * Add plugin menus
   * @since 0.1.0
   */
  $init->admin_menu();
} );

add_action( 'admin_init', function () {

  $init = AdminInit::get_instance();

  /**
   * Disable Yoast for specific roles.
   * @since 0.1.0
   */
  $init->yoast_disabled_roles();
  /**
   * Allow import/export settings.
   * @since 0.1.0
   */
  $init->register_settings_importer();
} );

add_action( 'admin_enqueue_scripts', function() {

  $init = AdminInit::get_instance();

  /**
   * Register and enqueue plugin scripts
   * @since 0.1.0
   */
  $init->enqueue_scripts();

  /**
   * Register and enqueue plugin styles
   * @since 0.1.0
   */
  $init->enqueue_styles();
} );

add_action( 'wp_ajax_jpdevtools_export_settings_json', function () {
  $init = AdminInit::get_instance();

  /**
   * Register and enqueue plugin styles
   * @since 0.1.0
   */
  $init->export_settings();
} );
