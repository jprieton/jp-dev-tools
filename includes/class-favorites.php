<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use wpdb;

/**
 * Favorite class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Favorite extends Singleton {

  /**
   * Favorite table name.
   *
   * @since   0.1.0
   * @var     string
   */
  private $table = 'user_favorite_posts';

  /**
   * @var type Favorite
   */
  static $instance;

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  protected function __construct() {
    $this->_create_table();
  }

  /**
   * Creates user_favorite_posts table
   *
   * @since 0.1.0
   *
   * @global wpdb           $wpdb
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
   * Update count of user's favorite post
   *
   * @since 0.1.0
   *
   * @global wpdb           $wpdb
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
   * Add post to favorites
   *
   * @since 0.1.0
   *
   * @global wpdb           $wpdb
   */
  private function add_post( $post_id ) {
    global $wpdb;
    $user_id = get_current_user_id();
    $wpdb->insert( "{$wpdb->prefix}{$this->table}", compact( 'post_id', 'user_id' ) );
    $this->_update_post_favorite_count( $post_id );
  }

  /**
   * Remove posts from favorites
   *
   * @since 0.1.0
   *
   * @global wpdb           $wpdb
   */
  private function remove_post( $post_id ) {
    global $wpdb;
    $user_id = get_current_user_id();
    $wpdb->delete( "{$wpdb->prefix}{$this->table}", compact( 'post_id', 'user_id' ) );
    $this->_update_post_favorite_count( $post_id );
  }

}
