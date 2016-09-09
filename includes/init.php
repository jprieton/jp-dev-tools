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
require_once __DIR__ . '/core/class-option-group.php';
require_once __DIR__ . '/factory/class-option-factory.php';

/**
 * Helper classes
 */
require_once __DIR__ . '/helpers/class-array-helper.php';
require_once __DIR__ . '/helpers/class-html-helper.php';
require_once __DIR__ . '/helpers/class-form-helper.php';

use JPDevTools\Core\Factory\OptionFactory;

add_action( 'init', function() {

  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( 'jpdevtools', false, JPDEVTOOLS_DIR . '/languages' );

  /**
   * Register option group.
   * @since 0.0.1
   */
  OptionFactory::register_option_group( 'jpdevtools' );
} );
