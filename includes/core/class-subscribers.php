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
 * Subscribers class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Subscribers {

  /**
   * Favorite table name.
   *
   * @since   0.1.0
   * @var     string
   */
  private $table = 'subscribers';

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    $this->_create_table();
  }

  /**
   * PHP5 style destructor and will run when object is destroyed.
   *
   * @since   0.1.0
   * @return  true
   */
  public function __destruct() {
    return true;
  }

  /**
   * Creates subscribers table
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
      $query   = "CREATE TABLE IF NOT EXISTS `{$wpdb->base_prefix}{$this->table}` ("
              . "`subscriber_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, "
              . "`subscriber_email` varchar(255) NULL, "
              . "`subscriber_field1` text NULL, "
              . "`subscriber_field2` text NULL, "
              . "`subscriber_field3` text NULL, "
              . "`subscriber_field4` text NULL, "
              . "`subscriber_field5` text NULL, "
              . "`subscriber_field6` text NULL, "
              . "`subscriber_list` int(11) NOT NULL DEFAULT 1, "
              . "`subscriber_timestamp` timestamp  NOT NULL DEFAULT CURRENT_TIMESTAMP, "
              . " PRIMARY KEY (`subscriber_id`) "
              . ") ENGINE=InnoDB {$charset} {$collate} AUTO_INCREMENT=1";
      $wpdb->query( $query );
    }
  }

  /**
   * The email exists in subscribers table?
   *
   * @since 0.2.0
   *
   * @global wpdb            $wpdb
   * @param  string          $email
   * @return bool
   */
  public function email_exists( $email ) {
    global $wpdb;

    if ( !is_email( $email ) ) {
      return false;
    }

    $exists = $wpdb->get_var( "SELECT subscriber_id FROM {$wpdb->base_prefix}{$this->table} WHERE subscriber_email = '{$email}' LIMIT 1" );

    return $exists;
  }

}
