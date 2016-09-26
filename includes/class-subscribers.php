<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use WP_REST_Server;
use WP_REST_Request;
use wpdb;

/**
 * Subscribers class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Subscribers extends Singleton {

  /**
   * Subscribers table name.
   *
   * @since   0.1.0
   * @var     string
   */
  private $table = 'subscribers';

  /**
   * Subscribers endpoint.
   *
   * @since   0.1.0
   * @var     string
   */
  private $endpoint = 'subscribers';

  /**
   * @var type SubscribersRestApi
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

  public function register_rest_routes() {
    $args = array(
        'methods'     => WP_REST_Server::ALLMETHODS,
        'accept_json' => true,
        'callback'    => array( $this, '_add_json_callback' ),
        'args'        => array(
            'subscriber_email'  => array(
                'required'          => true,
                'sanitize_callback' => 'sanitize_email'
            ),
            'subscriber_field1' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_field2' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_field3' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_field4' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_field5' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_field6' => array(
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field'
            ),
            'subscriber_list'   => array(
                'default'           => 0,
                'sanitize_callback' => 'absint'
            ),
        )
    );

    register_rest_route( $this->namespace, 'add.json', $args );
  }

  /**
   *
   * @param WP_REST_Request $wp_rest_request
   */
  public function _add_json_callback( $wp_rest_request ) {
    $response = array(
        'code'    => '',
        'message' => '',
        'data'    => array(
            'status' => 200
        ),
    );

    $fields['subscriber_email'] = $wp_rest_request->get_param( 'subscriber_email' );
    for ( $i = 1; $i < 7; $i++ ) {
      $fields["subscriber_field{$i}"] = $wp_rest_request->get_param( "subscriber_field{$i}" );
    }
    $fields['subscriber_list'] = $wp_rest_request->get_param( 'subscriber_list' );



    return $fields;
  }

}
