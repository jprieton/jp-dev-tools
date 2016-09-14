<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once JPDEVTOOLS_DIR . '/public/class-public-init.php';

use JPDevTools\Core\Init\PublicInit;

add_action( 'init', function() {

  $init = PublicInit::get_instance();

  /**
   * Disable WordPress Admin Bar in frontend in specific roles
   * @since 0.1.0
   */
  $init->disable_admin_bar_by_role();
} );

add_action( 'wp_enqueue_scripts', function() {

  $init = PublicInit::get_instance();

  /**
   * Register & enqueue plugin scripts
   * @since 0.1.0
   */
  $init->enqueue_scripts();

  /**
   * Register & enqueue plugin styles
   * @since 0.1.0
   */
  $init->enqueue_styles();
} );

add_action( 'wp_head', function() {

  $init = PublicInit::get_instance();

  /**
   * Shows Google Universal Analytics script
   * @since 0.1.0
   */
  $init->google_universal_analytics();
} );

add_action( 'before_main_content', function() {

  $init = PublicInit::get_instance();

  /**
   * Shows Google Tag Manager script
   * @since 0.1.0
   */
  $init->google_tag_manager();
} );

