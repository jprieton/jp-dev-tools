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
 * SeoSettings class
 *
 * @package        Core
 * @subpackage     Settings
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class SeoSettings extends SettingsPage {

  /**
   * Constructor
   *
   * @since   0.0.1
   */
  public function __construct() {
    parent::__construct( 'jpdevtools', 'jpdevtools_settings', 'jpdevtools_seo_settings' );
    $this->add_submenu_page( __( 'Analytics &amp; SEO', JPDEVTOOLS_TEXTDOMAIN ), __( 'Analytics &amp; SEO', JPDEVTOOLS_TEXTDOMAIN ) );
  }

}
