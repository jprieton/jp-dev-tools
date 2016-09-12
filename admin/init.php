<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once JPDEVTOOLS_DIR . '/admin/class-admin-init.php';
require_once JPDEVTOOLS_DIR . '/admin/class-general-settings.php';
require_once JPDEVTOOLS_DIR . '/admin/class-social-settings.php';
require_once JPDEVTOOLS_DIR . '/admin/class-advanced-settings.php';

use JPDevTools\Core\Init\AdminInit;

add_action( 'admin_menu', function () {

  $init = AdminInit::get_instance();

  /**
   * Add plugin menus
   * @since 0.0.1
   */
  $init->admin_menu();
} );

add_action( 'wp_enqueue_scripts', function() {

  $init = AdminInit::get_instance();

  /**
   * Register and enqueue plugin scripts
   * @since 0.0.1
   */
  $init->enqueue_scripts();

  /**
   * Register and enqueue plugin styles
   * @since 0.0.1
   */
  $init->enqueue_styles();
} );
