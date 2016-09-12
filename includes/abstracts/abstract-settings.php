<?php

namespace JPDevTools\Abstracts;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\Factory\OptionFactory;
use JPDevTools\Helpers\HtmlHelper as Html;
use JPDevTools\Helpers\FormHelper as Form;

/**
 * Settings abstract class
 *
 * @package        Core
 * @subpackage     Abstracts
 *
 * @since          0.0.1
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
abstract class Settings {

  /**
   * Page title
   * @since   0.0.1
   * @var     string
   */
  private $title;

  /**
   * Constructor
   *
   * @since   0.0.1
   *
   * @param   string         $option_group
   * @param   string         $menu
   * @param   string         $submenu
   */
  public function __construct( $option_group, $menu, $submenu = '' ) {
    $this->menu         = $menu;
    $this->submenu      = empty( $submenu ) ? $menu : $submenu;
    $this->option_group = $option_group;
    $this->options      = OptionFactory::option_group( $option_group );
  }

  /**
   * Add a top-level menu page.
   *
   * @since   0.0.1
   *
   * @param   string         $page_title
   * @param   string         $menu_title
   * @param   string         $capability
   * @param   string         $icon_url
   * @param   int            $position
   */
  public function add_menu_page( $page_title, $menu_title, $capability, $icon_url = 'dashicons-admin-generic', $position = null ) {
    add_menu_page( $page_title, $menu_title, $capability, $this->menu, '__return_null', $icon_url );
  }

  /**
   * Add a submenu page.
   *
   * @since   0.0.1
   *
   * @param   string         $page_title
   * @param   string         $menu_title
   * @param   string         $capability
   */
  public function add_submenu_page( $page_title, $menu_title, $capability = 'administrator' ) {
    $this->title = $page_title;
    add_submenu_page( $this->menu, $page_title, $menu_title, $capability, $this->submenu, array( $this, 'render_setting_page' ) );
  }

  /**
   * Add a new section to a settings page.
   *
   * @since   0.0.1
   *
   * @param   string         $section
   * @param   string         $title
   */
  public function add_setting_section( $section, $title ) {
    $this->section = $section;
    add_settings_section( $this->section, $title, '__return_null', $this->submenu );
  }

  /**
   * Render a settings page.
   *
   * @since   0.0.1
   *
   * @global   array         $wp_settings_sections
   * @global   array         $wp_settings_fields
   * @return   void
   */
  public function render_setting_page() {
    global $wp_settings_sections, $wp_settings_fields;

    if ( !array_key_exists( $this->submenu, $wp_settings_sections ) ) {
      return false;
    }

    echo Html::open_tag( '.wrap' );

    if ( !empty( $this->title ) ) {
      echo Html::tag( 'h2', $this->title );
    }

    settings_errors();

    echo Form::open( array( 'method' => 'post', 'action' => 'options.php' ) );

    settings_fields( $this->option_group );

    if ( !empty( $this->description ) ) {
      apply_filters( 'the_content', $this->description );
    }

    $tab_list = '';

    if ( count( (array) $wp_settings_sections[$this->submenu] ) > 1 ) {

      $tab_class = 'nav-tab nav-tab-active';

      foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {
        $tab_list  .= Html::a( '#', $section['title'], array( 'class' => $tab_class, 'data-target' => "#{$section['id']}" ) );
        $tab_class = 'nav-tab';
      }

      echo Html::tag( 'h2.nav-tab-wrapper.custom-nav-tab-wrapper', $tab_list );
    }

    foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {
      break;

      if ( $section['title'] && empty( $tab_list ) ) {
        printf( '<h2>%s</h2>', $section['title'] );
      }

      if ( $section['callback'] ) {
        call_user_func( $section['callback'], $section );
      }

      if ( !isset( $wp_settings_fields ) || !isset( $wp_settings_fields[$this->submenu] ) || !isset( $wp_settings_fields[$this->submenu][$section['id']] ) ) {
        continue;
      }

      printf( '<div class="data-tab" id="%s">', $section['id'] );

      echo '<table class="form-table">';
      do_settings_fields( $this->submenu, $section['id'] );
      echo '</table>';

      echo '</div>';
    }
    submit_button();
    echo '</form>';
    echo '</div>';
  }

}
