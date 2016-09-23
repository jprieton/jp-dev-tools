<?php

namespace JPDevTools\Core\Init;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Abstracts\Singleton;
use JPDevTools\Core\Factory\SettingFactory;
use JPDevTools\Core\Settings\GeneralSettings;
use JPDevTools\Core\Settings\SocialSettings;
use JPDevTools\Core\Settings\SeoSettings;
use JPDevTools\Core\Settings\AdvancedSettings;
use JPDevTools\Core\Settings\SupportSettings;

/**
 * AdminInit class
 *
 * @package        Core
 * @subpackage     Init
 *
 * @since          0.1.0
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class AdminInit extends Singleton {

  /**
   * Option group data
   *
   * @since 0.1.0
   *
   * @var JPDevTools\Core\OptionGroup;
   */
  private $setting_group;

  /**
   * Static instance of this class
   *
   * @since 0.1.0
   *
   * @var PublicInit;
   */
  protected static $instance;

  /**
   * Constructor
   *
   * @since   0.1.0
   */
  protected function __construct() {
    parent::__construct();

    // Load dependencies
    require_once JPDEVTOOLS_DIR . '/admin/class-general-settings.php';
    require_once JPDEVTOOLS_DIR . '/admin/class-social-settings.php';
    require_once JPDEVTOOLS_DIR . '/admin/class-seo-settings.php';
    require_once JPDEVTOOLS_DIR . '/admin/class-advanced-settings.php';
    require_once JPDEVTOOLS_DIR . '/admin/class-support-settings.php';

    $this->setting_group = SettingFactory::setting_group( 'jpdevtools-settings' );
  }

  /**
   * Add menu and submenu pages.
   *
   * @since   0.1.0
   */
  public function admin_menu() {

    new GeneralSettings();
    new SeoSettings();
    new SocialSettings();
    new AdvancedSettings();
    new SupportSettings();
  }

  /**
   * Enqueue admin scripts.
   *
   * @since   0.1.0
   */
  public function enqueue_scripts() {
    $scripts = array(
        'jpdevtools-admin' => array(
            'local'     => JPDEVTOOLS_URL . 'assets/js/admin.js',
            'deps'      => array( 'jquery' ),
            'ver'       => '0.1.0',
            'in_footer' => true,
            'autoload'  => true
        ),
    );

    /**
     * Filter plugin admin scripts
     *
     * @since   0.1.0
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'jpdevtools_admin_register_scripts', $scripts );

    $defaults = array(
        'local'     => '',
        'remote'    => '',
        'deps'      => array(),
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    );

    $use_cdn = $this->setting_group->get_bool_option( 'enable-cdn' );

    foreach ( $scripts as $handle => $script ) {
      $script = wp_parse_args( $script, $defaults );

      if ( ($use_cdn && !empty( $script['remote'] )) || empty( $script['local'] ) ) {
        $src = $script['remote'];
      } elseif ( (!$use_cdn && !empty( $script['local'] )) || empty( $script['remote'] ) ) {
        $src = $script['local'];
      } else {
        continue;
      }

      $deps      = $script['deps'];
      $ver       = $script['ver'];
      $in_footer = $script['in_footer'];

      /* Register admin scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue admin scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Filter localize scripts
     *
     * @since   0.1.0
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'jpdevtools_localize_scripts', array() );

    wp_localize_script( 'jpdevtools-admin', 'JPDevTools', $localize_script );
  }

  /**
   * Enqueue admin styles.
   *
   * @since   0.1.0
   */
  public function enqueue_styles() {

  }

}
