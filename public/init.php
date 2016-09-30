<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

require_once JPDEVTOOLS_DIR . '/public/class-public-init.php';
require_once JPDEVTOOLS_DIR . '/public/media.php';

use JPDevTools\Core\Init\PublicInit;

add_action( 'init', function() {

  $init = PublicInit::get_instance();

  /**
   * Disable WordPress Admin Bar in frontend in specific roles
   * @since 0.1.0
   */
  $init->disable_admin_bar_by_role();

  /**
   * Remove WordPress Version Number from header and feeds
   * @since 0.1.0
   */
  $init->remove_wordpress_version();

  /**
   * Remove the EditURI/RSD link and Windows Live Writer manifest link.
   * @since 0.1.0
   */
  $init->remove_rsd_link();

  /**
   * Disable XML-RCP/Pingback.
   * @since 0.1.0
   */
  $init->disable_xmlrpc();
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
  $init->open_graph_tags();
  $init->twitter_card_tags();
  $init->facebook_tags();
}, 0 );

add_action( 'wp_head', function() {

  $init = PublicInit::get_instance();

  /**
   * Shows Google Universal Analytics script
   * @since 0.1.0
   */
  $init->google_universal_analytics();

  /**
   * Shows Facebook Pixel Code
   * @since 0.1.0
   */
  $init->facebook_pixel_code();
}, 99 );

add_action( 'wp_footer', function() {

  $init = PublicInit::get_instance();

  /**
   * Shows Frontend helper
   * @since 0.1.0
   */
  $init->frontend_helper();
} );

add_action( 'before_main_content', function() {

  $init = PublicInit::get_instance();

  /**
   * Shows Google Tag Manager script
   * @since 0.1.0
   */
  $init->google_tag_manager();
} );

// Register Theme Features
add_action( 'after_setup_theme', function () {

  /**
   * Add theme support for Featured Images
   * @since 0.1.0
   */
  add_theme_support( 'post-thumbnails' );

  /**
   * Add theme support for document Title tag
   * @since 0.1.0
   */
  add_theme_support( 'title-tag' );
} );

add_filter( 'post_thumbnail_html', function($html, $post_id, $post_thumbnail_id, $size, $attr) {

  $init = PublicInit::get_instance();

  /**
   * Shows a default image when the post don't have featured image
   * @since 0.1.0
   */
  return $init->post_thumbnail_html( $html, $post_id, $post_thumbnail_id, $size, $attr );
}, 10, 5 );
