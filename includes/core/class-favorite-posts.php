<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use wpdb;

/**
 * FavoritePost class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class FavoritePosts {

  /**
   * Favorite table name.
   *
   * @since   0.1.0
   * @var     string
   */
  private $table = 'favorite_posts';

  /**
   * OptionGroup object.
   *
   * @since   0.1.0
   * @var SettingGroup
   */
  private $option_group;

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    $this->_create_table();
    $this->option_group = new SettingGroup( 'jpdevtools' );
  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since   0.1.0
   * @return  true
   */
  public function __destruct() {
    unset( $this->option_group );
    return true;
  }

  /**
   * Creates subscriber table
   *
   * @since   0.1.0
   * @global  wpdb           $wpdb
   */
  private function _create_table() {
    global $wpdb;

    $table_exists = (bool) $wpdb->get_row( "SHOW TABLES LIKE '{$wpdb->prefix}{$this->table}'" );

    if ( !$table_exists ) {
      $charset = $wpdb->charset ? "DEFAULT CHARACTER SET {$wpdb->charset}" : '';
      $collate = $wpdb->collate ? "COLLATE {$wpdb->collate}" : '';
      $query   = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}{$this->table}` ("
              . "`post_id` bigint(20) unsigned NOT NULL, "
              . "`user_id` bigint(20) unsigned NOT NULL, "
              . "PRIMARY KEY (`post_id`, `user_id`), "
              . "KEY `user_id` (`user_id`)"
              . ") ENGINE=InnoDB {$charset} {$collate}";
      $wpdb->query( $query );
    }
  }

  /**
   * Returns the count of users that have marked the article as favorite.
   *
   * @since   0.1.0
   * @param   int            $post_id
   * @return  int            Count of users
   */
  public function get_post_favorite_count( $post_id = null ) {
    if ( is_null( $post_id ) ) {
      $post_id = get_the_ID();
    }

    if ( !is_numeric( $post_id ) ) {
      return 0;
    }

    $favorite_count     = (int) get_post_meta( $post_id, '_favorite_count', true );
    $favorite_timestamp = (int) get_post_meta( $post_id, '_favorite_timestamp', true );
    $current_timestamp  = time();
    $diff               = $current_timestamp - $favorite_timestamp;

    $favorite_timeout_cache = $this->option_group->get_int_option( 'favorite_timeout_cache', 60 * MINUTE_IN_SECONDS );

    if ( $diff > $favorite_timeout_cache ) {
      $favorite_count = $this->_update_post_favorite_count( $post_id );
    }

    return (int) $favorite_count;
  }

  /**
   * Update and return the count of users that have marked the article as favorite .
   *
   * @since   0.1.0
   *
   * @global  wpdb           $wpdb
   * @param   int            $post_id
   *
   * @return  int            Count of users
   */
  private function _update_post_favorite_count( $post_id ) {
    global $wpdb;
    $query          = $wpdb->prepare( "SELECT count(`user_id`) as count FROM {$wpdb->prefix}{$this->table} WHERE post_id = %d", $post_id );
    $favorite_count = $wpdb->get_var( $query );

    // Update favorite counts
    update_post_meta( $post_id, '_favorite_count', $favorite_count );
    update_post_meta( $post_id, '_favorite_timestamp', time() );

    return $favorite_count;
  }

  /**
   * Is user favorite post?
   *
   * @since   0.1.0
   *
   * @global  wpdb           $wpdb
   * @param   int            $user_id
   * @param   int            $post_id
   *
   * @return  boolean
   */
  public function is_favorite_post( $post_id = null ) {
    $user_id = get_current_user_id();
    $post_id = (int) $post_id ?: get_the_ID();

    if ( !$user_id && !$post_id ) {
      return false;
    }

    global $wpdb;
    $query       = $wpdb->prepare( "SELECT 1 as favorite FROM {$wpdb->prefix}{$this->table} WHERE post_id = %d AND user_id = %d LIMIT 1", $post_id, $user_id );
    $is_favorite = (bool) $wpdb->get_var( $query );

    return $is_favorite;
  }

  /**
   * Add post to favorites
   *
   * @since   0.1.0
   *
   * @global  wpdb           $wpdb
   * @param   type           $post_id
   */
  public function add_favorite_post( $post_id ) {
    global $wpdb;
    $user_id = get_current_user_id();
    $wpdb->insert( "{$wpdb->prefix}{$this->table}", compact( 'post_id', 'user_id' ) );
    $this->_update_post_favorite_count( $post_id );
  }

  /**
   * Remove post from favorites
   *
   * @since   0.1.0
   *
   * @global  wpdb           $wpdb
   * @param   type           $post_id
   */
  public function remove_favorite_post( $post_id ) {
    global $wpdb;
    $user_id = get_current_user_id();
    $wpdb->delete( "{$wpdb->prefix}{$this->table}", compact( 'post_id', 'user_id' ) );
    $this->_update_post_favorite_count( $post_id );
  }

  /**
   * Toggle post in favorites
   *
   * @since   0.1.0
   * 
   * @param   type           $post_id
   * @return  type
   */
  public function toggle_favorite_post( $post_id ) {
    $is_favorite = $this->is_favorite_post( $post_id );

    if ( $is_favorite ) {
      $this->remove_favorite_post( $post_id );
    } else {
      $this->add_favorite_post( $post_id );
    }

    return !$is_favorite;
  }

}
