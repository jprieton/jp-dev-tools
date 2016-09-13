<?php

namespace JPDevTools\Core\Settings;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\Factory\SettingFactory;
use JPDevTools\Helpers\HtmlHelper;
use JPDevTools\Helpers\FormHelper;

abstract class AdminSettings {

  public $options;
  public $menu;
  public $submenu;
  public $option_group;
  public $title;
  public $description;
  public $section;

  /**
   * @since 0.0.1
   *
   * @param string $option_group
   * @param string $menu
   * @param string $submenu
   */
  public function __construct( $option_group = '', $menu = '', $submenu = '' ) {
    $this->option_group = $option_group;
    $this->menu         = $menu;
    $this->submenu      = empty( $submenu ) ? $menu : $submenu;
    $this->options      = SettingFactory::setting_group( $option_group );
  }

  /**
   * @since 0.2.0
   *
   * @param string $page_title
   * @param string $menu_title
   * @param string $capability
   * @param string $icon_url
   * @param string $position
   */
  public function add_menu_page( $page_title, $menu_title, $capability, $icon_url = 'dashicons-admin-generic', $position = null ) {
    add_menu_page( $page_title, $menu_title, $capability, $this->menu, '__return_null', $icon_url );
  }

  /**
   * @since 0.2.0
   *
   * @param string $page_title
   * @param string $menu_title
   * @param string $capability
   */
  public function add_submenu_page( $page_title, $menu_title, $capability = 'administrator' ) {
    $this->title = $page_title;
    add_submenu_page( $this->menu, $page_title, $menu_title, $capability, $this->submenu, array( $this, 'render_setting_page' ) );
  }

  /**
   * @since 0.2.0
   *
   * @param string $section
   * @param string $title
   */
  public function add_setting_section( $section, $title ) {
    $this->section = $section;
    add_settings_section( $this->section, $title, '__return_null', $this->submenu );
  }

  /**
   *
   * @param array $field
   * @return boolean
   */
  public function add_field( $field ) {
    if ( (!is_array( $field ) || !array_key_exists( 'name', $field ) ) && array_key_exists( 'options', $field ) ) {
      return false;
    }

    if ( array_key_exists( 'class', $field ) ) {
      $field['input_class'] = $field['class'];
      unset( $field['class'] );
    }

    $defaults = array(
        'type' => 'text',
        'desc' => '',
        'id'   => null
    );

    $field = wp_parse_args( $field, $defaults );

    switch ( $field['type'] ) {
      case 'checkbox':
        $callback = array( &$this, 'render_checkbox' );
        break;

      case 'textarea':
        $callback = array( &$this, 'render_textarea' );
        break;

      case 'text':
      case 'password':
      case 'email':
      default:
        $callback = array( &$this, 'render_input' );
        break;
    }

    add_settings_field( $field['id'], $field['name'], $callback, $this->submenu, $this->section, $field );
  }

  /**
   * @since 0.2.0
   *
   * @param array $field
   */
  public function render_input( $field ) {

    if ( !array_key_exists( 'value', $field ) ) {
      $default        = array_key_exists( 'default', $field ) ? $field['default'] : '';
      $field['value'] = smg_get_option( $field['id'], $default, $this->option_group );
    }

    if ( array_key_exists( 'default', $field ) ) {
      unset( $field['default'] );
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    $field['value'] = esc_attr( $field['value'] );
    $field['name']  = sprintf( "{$this->option_group}[%s]", $field['id'] );

    if ( array_key_exists( 'desc', $field ) ) {
      $description = apply_filters( 'the_content', $field['desc'] );
      $description = str_replace( '<p>', '<p class="description">', $description );
      unset( $field['desc'] );
    } else {
      $description = '';
    }

    $input = sprintf( '<input %s>', smg_parse_attr( $field ) );

    echo $input . $description;
  }

  /**
   * @since 0.2.0
   *
   * @param array $field
   */
  public function render_textarea( $field ) {

    if ( !array_key_exists( 'value', $field ) ) {
      $default = array_key_exists( 'default', $field ) ? $field['default'] : '';
      $value   = smg_get_option( $field['id'], $default, $this->option_group );
      unset( $field['value'] );
    }

    if ( array_key_exists( 'default', $field ) ) {
      unset( $field['default'] );
    }

    if ( array_key_exists( 'id', $field ) ) {
      if ( $field['id'] == null ) {
        unset( $field['default'] );
      }
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    $field['name'] = sprintf( "{$this->option_group}[%s]", $field['id'] );

    if ( array_key_exists( 'desc', $field ) ) {
      $description = apply_filters( 'the_content', $field['desc'] );
      $description = str_replace( '<p>', '<p class="description">', $description );
      unset( $field['desc'] );
    } else {
      $description = '';
    }

    $input = sprintf( '<textarea %s>%s</textarea>', smg_parse_attr( $field ), esc_textarea( $value ) );

    echo $input . $description;
  }

  /**
   * @since 0.2.0
   *
   * @param array $field
   */
  public function render_checkbox( $field ) {

    $options = array();

    $is_multiple = false;
    if ( array_key_exists( 'options', $field ) ) {
      $options     = $field['options'];
      unset( $field['options'] );
      $is_multiple = true;
    }

    if ( array_key_exists( 'input_class', $field ) ) {
      $field['class'] = $field['input_class'];
      unset( $field['input_class'] );
    }

    if ( empty( $options ) ) {
      $options[] = $field;
    }

    foreach ( $options as $item ) {
      $label = '%s';
      if ( array_key_exists( 'label', $item ) ) {
        $label .= " <b>{$item['label']}</b>";
        unset( $item['label'] );
      }

      if ( array_key_exists( 'desc', $item ) ) {
        $description = apply_filters( 'the_content', $item['desc'] );
        $description = str_replace( '<p>', '<p class="description">', $description );
        unset( $item['desc'] );
      } else {
        $description = '';
      }

      $item['name'] = sprintf( "{$this->option_group}[%s]", $item['id'] );

      if ( smg_get_option( $item['id'], 'no', $this->option_group ) == 'yes' ) {
        $item['checked'] = 'checked';
      }

      $item['value'] = 'yes';

      if ( $is_multiple ) {
        $item = array_merge( $field, $item );
      }

      $label = sprintf( '<label for="%s">%s</label>', $item['id'], $label );
      $input = sprintf( '<input type="hidden" name="%s" value="no">', $item['name'] );
      $input .= sprintf( '<input %s>', smg_parse_attr( $item ) );

      echo sprintf( $label, $input ) . $description;
    }
  }

  /**
   * @since 0.2.0
   *
   * @global array $wp_settings_sections
   * @global array $wp_settings_fields
   * @return void
   */
  public function render_setting_page() {
    global $wp_settings_sections, $wp_settings_fields;

    if ( !array_key_exists( $this->submenu, $wp_settings_sections ) ) {
      return false;
    }

    echo '<div class="wrap">';

    if ( !empty( $this->title ) ) {
      printf( '<h2>%s</h2>', $this->title );
    }

    settings_errors();

    echo '<form method="post" action="options.php">';

    settings_fields( $this->option_group );

    if ( !empty( $this->description ) ) {
      apply_filters( 'the_content', $this->description );
    }

    $tab_list = '';

    if ( count( (array) $wp_settings_sections[$this->submenu] ) > 1 ) {

      $tab_class = 'nav-tab nav-tab-active';

      foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {
        $tab_list  .= sprintf( '<a href="#" class="%s" data-target="%s">%s</a>', $tab_class, "#{$section['id']}", $section['title'] );
        $tab_class = 'nav-tab';
      }
      printf( '<h2 class="nav-tab-wrapper custom-nav-tab-wrapper">%s</h2>', $tab_list );
    }

    foreach ( (array) $wp_settings_sections[$this->submenu] as $section ) {

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
