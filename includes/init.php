<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Abstract classes
 */
require_once __DIR__ . '/abstracts/class-singleton.php';

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
  load_plugin_textdomain( 'jpwp', false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );
} );
