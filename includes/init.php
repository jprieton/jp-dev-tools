<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Core classes
 */
require_once __DIR__ . '/abstracts/abstract-singleton.php';
require_once __DIR__ . '/abstracts/abstract-settings-page.php';
require_once __DIR__ . '/core/class-setting-group.php';
require_once __DIR__ . '/factory/class-setting-factory.php';

/**
 * Helper classes
 */
require_once __DIR__ . '/helpers/class-array-helper.php';
require_once __DIR__ . '/helpers/class-html-helper.php';
require_once __DIR__ . '/helpers/class-form-helper.php';

use JPDevTools\Core\Factory\SettingFactory;

add_action( 'init', function() {


  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( JPDEVTOOLS_TEXTDOMAIN, false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );

  /**
   * Register option group.
   * @since 0.0.1
   */
  SettingFactory::register_setting_group( 'jpdevtools-settings' );
} );

// Register Theme Features
add_action( 'after_setup_theme', function () {

  // Add theme support for Featured Images
  add_theme_support( 'post-thumbnails' );

  // Add theme support for document Title tag
  add_theme_support( 'title-tag' );
} );

