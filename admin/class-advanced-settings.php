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
 * AdvancedSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class AdvancedSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.0.1
   */
  public function __construct() {
    parent::__construct( 'jpdevtools', 'jpdevtools_settings', 'jpdevtools_advanced' );
    $this->add_submenu_page( __( 'Advanced', JPDEVTOOLS_TEXTDOMAIN ), __( 'Advanced', JPDEVTOOLS_TEXTDOMAIN ), 'administrator' );
  }

}
