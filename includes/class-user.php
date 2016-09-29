<?php

namespace JPDevTools\Core;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * User class
 *
 * @package        Core
 *
 * @since          0.1.0
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class User {

  /**
   * OptionGroup object.
   *
   * @since   0.1.0
   * @var SettingGroup
   */
  private $setting_group;

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    $this->setting_group = new SettingGroup( 'jpdevtools' );
  }

  /**
   * @since 0.1.0
   *
   * @param  int            $user_id
   * @return bool
   */
  public function is_blocked( $user_id ) {
    $user_blocked = get_user_meta( $user_id, 'user_blocked', true );
    return (bool) ( 'yes' == $user_blocked );
  }

  /**
   * @since 0.1.0
   *
   * @param int             $user_id
   */
  public function add_attempt( $user_id ) {
    $login_attempts = (int) get_user_meta( $user_id, 'login_attempts', true );
    $login_attempts++;

    $max_login_attemps = $this->setting_group->get_int_option( 'max-login-attemps', -1 );
    if ( $max_login_attemps > 1 && $login_attempts > $max_login_attemps ) {
      update_user_meta( $user_id, 'user_blocked', 'yes' );
    }

    update_user_meta( $user_id, 'login_attempts', $login_attempts );
  }

  /**
   * @since 0.1.0
   *
   * @param int             $user_id
   */
  public function clear_attempt( $user_id ) {
    delete_user_meta( $user_id, 'login_attempts' );
    delete_user_meta( $user_id, 'user_blocked' );
  }

}
