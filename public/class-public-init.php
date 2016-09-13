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

/**
 * InitPublic class
 *
 * @package        Core
 * @subpackage     Init
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class PublicInit extends Singleton {

  /**
   * Option group data
   *
   * @since 0.0.1
   *
   * @var JPDevTools\Core\OptionGroup;
   */
  private $option_group;

  /**
   * Static instance of this class
   *
   * @since 0.0.1
   *
   * @var PublicInit;
   */
  protected static $instance;

  /**
   * Constructor
   *
   * @since   0.0.1
   */
  protected function __construct() {
    parent::__construct();
    $this->option_group = SettingFactory::setting_group( 'jpdevtools' );
  }

  /**
   * Disable WordPress Admin Bar in frontend in specific roles.
   *
   * @since 0.0.1
   */
  public function disable_admin_bar_by_role() {
    $disabled_roles = (array) $this->option_group->get_option( 'admin-bar-disabled-roles', array() );
    $user           = wp_get_current_user();

    // By default is enabled in all roles.
    if ( empty( $disabled_roles ) || !$user ) {
      return;
    }

    foreach ( $user->roles as $user_rol ) {
      if ( in_array( $user_rol, $disabled_roles ) ) {
        add_filter( 'show_admin_bar', '__return_false' );
        break;
      }
    }
  }

  /**
   * Register & enqueue plugin scripts
   *
   * @since 0.0.1
   */
  public function enqueue_scripts() {
    $scripts = array(
        'bootstrap'  => array(
            'local'     => JPDEVTOOLS_URL . 'assets/js/bootstrap.min.js',
            'remote'    => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
            'deps'      => array( 'jquery' ),
            'ver'       => '3.3.7',
            'in_footer' => true,
            'autoload'  => false
        ),
        'jpdevtools' => array(
            'local'     => JPDEVTOOLS_URL . 'assets/js/public.js',
            'deps'      => array( 'jquery' ),
            'ver'       => '0.0.1',
            'in_footer' => true,
            'autoload'  => true
        ),
        'modernizr'  => array(
            'local'    => JPDEVTOOLS_URL . 'assets/js/modernizr.min.js',
            'remote'   => '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js',
            'ver'      => '2.8.3',
            'autoload' => true
        ),
    );

    /**
     * Filter plugin scripts
     *
     * @since   0.0.1
     * @param   array   $scripts
     */
    $scripts = apply_filters( 'jpdevtools_register_scripts', $scripts );

    $defaults = array(
        'local'     => '',
        'remote'    => '',
        'deps'      => array(),
        'ver'       => null,
        'in_footer' => false,
        'autoload'  => false
    );

    $use_cdn = $this->option_group->get_bool_option( 'enable-cdn' );

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

      /* Register scripts */
      wp_register_script( $handle, $src, (array) $deps, $ver, (bool) $in_footer );

      if ( $script['autoload'] ) {
        /* Enqueue scripts if autolad in enabled */
        wp_enqueue_script( $handle );
      }
    }

    /**
     * Localize public script
     *
     * @since   0.0.1
     */
    $localize_script = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'messages' => array(
            'success' => __( 'Success!', 'jpdevtools' ),
            'fail'    => __( 'Fail!', 'jpdevtools' ),
            'error'   => __( 'Error!', 'jpdevtools' ),
            'send'    => __( 'Send', 'jpdevtools' ),
            'sent'    => __( 'Sent!', 'jpdevtools' ),
        )
    );

    /**
     * Filter localize scripts
     *
     * @since   0.0.1
     * @param   array   $localize_script
     */
    $localize_script = apply_filters( 'jpdevtools_localize_scripts', $localize_script );

    wp_localize_script( 'jpdevtools', 'JPDevTools', $localize_script );
  }

  /**
   * Register & enqueue plugin styles
   *
   * @since 0.0.1
   */
  public function enqueue_styles() {
    /**
     * Plugin styles
     *
     * @since 0.0.1
     */
    $styles = array(
        'bootstrap'    => array(
            'remote' => '//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
            'ver'    => '3.3.7',
        ),
        'font-awesome' => array(
            'remote' => '//maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css',
            'ver'    => '4.6.3',
        ),
        'animate'      => array(
            'local'  => JPDEVTOOLS_URL . 'assets/css/animate.min.css',
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css',
            'ver'    => '3.5.2',
            'media'  => 'screen',
        ),
        'hover'        => array(
            'local'  => JPDEVTOOLS_URL . 'assets/css/hover.min.css',
            'remote' => '//cdnjs.cloudflare.com/ajax/libs/hover.css/2.0.2/css/hover-min.css',
            'ver'    => '2.0.2',
            'media'  => 'screen',
        ),
        'jpdevtools'   => array(
            'local'    => JPDEVTOOLS_URL . 'assets/css/public.css',
            'ver'      => '0.1.0',
            'autoload' => true
        ),
    );

    /**
     * Filter styles
     *
     * @since   0.0.1
     * @param   array   $styles
     */
    $styles = apply_filters( 'jpdevtools_register_styles', $styles );

    $defaults = array(
        'local'    => '',
        'remote'   => '',
        'deps'     => array(),
        'ver'      => null,
        'media'    => 'all',
        'autoload' => false
    );

    $use_cdn = $this->option_group->get_bool_option( 'enable-cdn' );

    foreach ( $styles as $handle => $style ) {
      $style = wp_parse_args( $style, $defaults );

      if ( ($use_cdn && !empty( $style['remote'] )) || empty( $style['local'] ) ) {
        $src = $style['remote'];
      } elseif ( (!$use_cdn && !empty( $style['local'] )) || empty( $style['remote'] ) ) {
        $src = $style['local'];
      } else {
        continue;
      }

      $deps  = $style['deps'];
      $ver   = $style['ver'];
      $media = $style['media'];

      /* Register styles */
      wp_register_style( $handle, $src, (array) $deps, $ver, $media );

      if ( $style['autoload'] ) {
        /* Enqueue styles if autolad in enabled */
        wp_enqueue_style( $handle );
      }
    }
  }

}
