<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\SettingsPage;

/**
 * GeneralSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class GeneralSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.0.1
   */
  public function __construct() {
    parent::__construct( 'jpdevtools', 'jpdevtools_settings', 'jpdevtools_settings' );
    $this->add_menu_page( 'JPDevTools', 'JPDevTools', 'administrator', 'dashicons-admin-tools' );
    $this->add_submenu_page( 'General Settings', 'General Settings' );
  }

}
