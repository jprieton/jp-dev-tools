<?php

namespace JPDevTools\Core\Api;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\User;
use JPDevTools\Core\Factory\ErrorFactory;
use WP_Error;

/**
 * UserApi class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class UserApi extends User {

  public function __construct() {
    parent::__construct();
  }

  public function json_authenticate() {
    $nonce        = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    $verify_nonce = (bool) wp_verify_nonce( $nonce, 'jpdevtools_user_authenticate_json' );

    if ( !$verify_nonce ) {
      wp_send_json_error( ErrorFactory::unauthorized() );
    }

    $user_login    = strtolower( sanitize_email( filter_input( INPUT_POST, 'user_login', FILTER_SANITIZE_EMAIL ) ) );
    $user_password = sanitize_text_field( filter_input( INPUT_POST, 'user_password', FILTER_SANITIZE_STRING ) );
    $remember      = sanitize_text_field( filter_input( INPUT_POST, 'remember', FILTER_SANITIZE_STRING ) );

    // Only login with email
    if ( !is_email( $user_login ) ) {
      $error = new WP_Error( 'invalid_email', __( 'Invalid email' ) );
      wp_send_json_error( $error );
    }

    $user = get_user_by( 'email', $user_login );

    if ( !$user ) {
      $error = new WP_Error( 'wrong_user_password', __( 'Email or password is incorrect' ) );
      wp_send_json_error( $error );
    }

    if ( $this->_is_blocked( $user->ID ) ) {
      $error = new WP_Error( 'user_blocked', __( 'Your user is blocked' ) );
      wp_send_json_error( $error );
    }

    // Hook before authenticate
    do_action( 'pre_jpdevtools_user_authenticate_json', $user_login, $user_password );

    $userdata = wp_signon( compact( 'user_login', 'user_password', 'remember' ), false );

    // Hook after authenticate
    do_action( 'post_jpdevtools_user_authenticate_json', $userdata );

    if ( is_wp_error( $userdata ) ) {
      $this->_add_attempt( $user->ID );

      if ( $this->_is_blocked( $user->ID ) ) {
        $error = new WP_Error( 'user_blocked', __( 'Your user is blocked' ) );
        wp_send_json_error( $error );
      } else {
        wp_send_json_error( $userdata );
      }
    } else {
      $this->_clear_attempt( $user->ID );
      $response[] = array(
          'code'    => 'user_login_success',
          'message' => __( 'Login success' ),
      );
      wp_send_json_success( $response );
    }
  }

  public function json_register() {
    $nonce        = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
    $verify_nonce = (bool) wp_verify_nonce( $nonce, 'hasbarapp_user_register_json' );

    if ( !$verify_nonce ) {
      $error = new WP_Error( 'action_disabled', __( 'Action disabled' ) );
      wp_send_json_error( $error );
    }

    $user_email = strtolower( sanitize_email( filter_input( INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL ) ) );
    $user_pass  = sanitize_text_field( filter_input( INPUT_POST, 'user_pass', FILTER_SANITIZE_STRING ) );
    $user_login = $nickname   = $user_email;

    if ( !is_email( $user_email ) ) {
      $error = new WP_Error( 'bad_user_email', __( 'Invalid email' ) );
      wp_send_json_error( $error );
    }

    if ( empty( $user_pass ) ) {
      $error = new WP_Error( 'empty_password', __( 'Empty password' ) );
      wp_send_json_error( $error );
    }

    $user_pass_confirm = sanitize_text_field( filter_input( INPUT_POST, 'user_pass_confirm', FILTER_SANITIZE_STRING ) );
    if ( $user_pass != $user_pass_confirm ) {
      $error = new WP_Error( 'password_error', __( 'Password does not match with the confirm password.' ) );
      wp_send_json_error( $error );
    }

    $userdata = compact( 'user_email', 'user_login', 'user_pass', 'nickname' );

    $first_name = sanitize_text_field( filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING ) );
    if ( !empty( $first_name ) ) {
      $userdata = array_merge( $userdata, compact( 'first_name' ) );
      $userdata = array_merge( $userdata, array( 'display_name' => $first_name ) );
    }

    $last_name = sanitize_text_field( filter_input( INPUT_POST, 'first_name', FILTER_SANITIZE_STRING ) );
    if ( !empty( $last_name ) ) {
      $userdata = array_merge( $userdata, compact( 'last_name' ) );
    }

    $userdata = apply_filters( 'pre_smg_user_register', $userdata );

    $user_id = wp_insert_user( $userdata );

    do_action( 'post_smg_user_register', $user_id );

    if ( is_wp_error( $user_id ) ) {
      wp_send_json_error( $user_id );
    } else {
      update_user_meta( $user_id, 'show_admin_bar_front', 'false' );
      $response = array(
          'code'    => 'user_register_success',
          'message' => __( 'Registro exitoso' ),
      );
      wp_send_json_success( array( $response ) );
    }
  }

}
