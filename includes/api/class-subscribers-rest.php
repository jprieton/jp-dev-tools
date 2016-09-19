<?php

namespace JPDevTools\Api;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use WP_REST_Server;
use WP_REST_Request;

/**
 * SubscribersRest class
 *
 * @package        API
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SubscribersRestApi extends Singleton {

  private $namespace = 'subscribers';

  /**
   * @var type SubscribersRestApi
   */
  static $instance;

  public function register_add_rest_route() {
    $args = array(
        'methods'     => WP_REST_Server::ALLMETHODS,
        'accept_json' => true,
        'callback'    => array( $this, 'add_rest_route_callback' ),
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
  public function add_rest_route_callback( $wp_rest_request ) {
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
