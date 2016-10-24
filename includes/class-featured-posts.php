<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\Factory\SettingFactory;
use JPDevTools\Core\SettingGroup;
use JPDevTools\Helpers\HtmlBuilder as Html;
use JPDevTools\Core\Factory\ErrorFactory;

/**
 * FeaturedPosts class
 *
 * @package Core
 * @since 0.5.0
 * @author jprieton
 */
class FeaturedPosts extends Singleton {

  /**
   * @var SettingGroup
   */
  private $setting_group;

  /**
   * @var type FeaturedPosts
   */
  static $instance;

  /**
   * @var array
   */
  private $post_types_disabled = array( 'page' );

  /**
   * Constructor
   *
   * @since   0.5.0
   */
  public function __construct() {
    parent::__construct();

    $this->setting_group = SettingFactory::setting_group( 'jpdevtools-settings' );

    if ( function_exists( 'WC' ) ) {
      $this->post_types_disabled[] = 'product';
    }

    $this->post_types_disabled = (array) apply_filters( 'featured_post_types_disabled', $this->post_types_disabled );
  }

  /**
   * Toggle featured posts
   *
   * @since   0.5.0
   *
   * @param int $post_id
   * @return boolean
   */
  public function toggle_featured_posts( $post_id = 0 ) {
    $post_id  = (int) $post_id;
    $featured = get_post_meta( $post_id, '_featured', true );

    if ( 'yes' == $featured ) {
      delete_post_meta( $post_id, '_featured' );
      return false;
    } else {
      update_post_meta( $post_id, '_featured', 'yes' );
      return true;
    }
  }

  /**
   * Add featured column to admin pages
   *
   * @since   0.5.0
   *
   * @param   string    $column_name
   * @param   int       $post_id
   * @return  null
   */
  public function manage_custom_columns( $column_name, $post_id = '' ) {

    if ( 'featured' != $column_name ) {
      return;
    }
    if ( !empty( $this->post_types_disabled ) && in_array( get_post_type( $post_id ), $this->post_types_disabled ) ) {
      return;
    }

    $featured = get_post_meta( $post_id, '_featured', true );
    if ( in_array( $featured, array( 'yes', 1 ) ) ) {
      echo '<a href="#" class="dashicons dashicons-star-filled toggle-featured" data-id="' . $post_id . '"></a>';
    } else {
      echo '<a href="#" class="dashicons dashicons-star-empty toggle-featured" data-id="' . $post_id . '"></a>';
    }
  }

  /**
   * Add featured column to admin pages
   *
   * @since   0.5.0
   *
   * @param   array     $posts_columns
   * @param   string    $post_type
   * @return  array
   */
  public function manage_columns( $posts_columns, $post_type = null ) {
    if ( in_array( $post_type, $this->post_types_disabled ) ) {
      return $posts_columns;
    }

    $new = array(
        'cb'       => $posts_columns['cb'],
        'featured' => '<span class="dashicons dashicons-star-filled" title="' . __( 'Featured', JPDEVTOOLS_TEXTDOMAIN ) . '"><span class="screen-reader-text">' . __( 'Featured', JPDEVTOOLS_TEXTDOMAIN ) . '</span></span>'
    );

    $posts_columns = array_merge( $new, $posts_columns );
    return $posts_columns;
  }

  /**
   * Add backend funcionality to toggle featured posts
   *
   * @since   0.5.0
   */
  public function wp_ajax_toggle_featured_post() {
    if ( !is_admin() ) {
      wp_send_json_error( ErrorFactory::unauthorized() );
    }

    $post_id = (int) filter_input( INPUT_POST, 'post_id', FILTER_SANITIZE_NUMBER_INT );

    if ( empty( $post_id ) ) {
      wp_send_json_error( ErrorFactory::invalid_data() );
    }

    $post = get_post( $post_id );

    if ( empty( $post ) ) {
      wp_send_json_error( ErrorFactory::invalid_data() );
    }

    $featured = $this->toggle_featured_posts( $post->ID );
    wp_send_json_success( compact( 'featured' ) );
  }

}
