<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Core\OptionGroup;

/**
 * Core classes
 */
require_once __DIR__ . '/core/class-option-group.php';

/**
 * Helper classes
 */
require_once __DIR__ . '/helpers/class-array-helper.php';
require_once __DIR__ . '/helpers/class-html-helper.php';
require_once __DIR__ . '/helpers/class-form-helper.php';

add_action( 'init', function() {

  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( 'jpdevtools', false, JPDEVTOOLS_DIR . '/languages' );

  /**
   * Merge options before saving.
   * @since 0.0.1
   */
  add_filter( 'pre_update_option_jpdevtools', array( new OptionGroup( 'jpdevtools' ), 'pre_update_option' ), 10, 2 );
} );
