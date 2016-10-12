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
 * FormSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class FormSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  public function __construct() {
    $form_fields = array();

    /** Filter to add fields */
    $form_fields = apply_filters( 'jpdevtools_form_addresses', $form_fields );

    if ( empty( $form_fields ) ) {
      return;
    }

    parent::__construct( 'jpdevtools-settings', 'jpdevtools_settings', 'jpdevtools_form_settings' );
    $this->add_submenu_page( __( 'Forms', JPDEVTOOLS_TEXTDOMAIN ), __( 'Forms', JPDEVTOOLS_TEXTDOMAIN ) );

    $this->add_setting_section( 'jpdevtools_form_settings_section_address', __( 'Addresses', JPDEVTOOLS_TEXTDOMAIN ) );

    foreach ( $form_fields as $key => $label ) {
      $this->add_field( array(
          'name'  => $label,
          'id'    => $key,
          'type'  => 'text',
          'class' => 'regular-text code',
      ) );
    }
    do_action( 'jpdevtools_form_settings', $this );
  }

}
