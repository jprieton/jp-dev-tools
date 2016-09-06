<?php

use JPDevTools\PostTypes\PostTypeSlider;

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
require_once __DIR__ . '/abstracts/class-post-type.php';

/**
 * Core classes
 */
require_once __DIR__ . '/core/class-option-group.php';
//require_once __DIR__ . '/config/class-option.php';

/**
 * Post Types classes
 */
require_once __DIR__ . '/post-types/class-post-type-slider.php';

/**
 * Helper classes
 */
require_once __DIR__ . '/helpers/class-array-helper.php';
require_once __DIR__ . '/helpers/class-html-helper.php';
require_once __DIR__ . '/helpers/class-form-helper.php';

/**
 * Main class
 */
require_once __DIR__ . '/class-jp-dev-tools.php';

add_action( 'init', function() {

  /**
   * Loads the plugin's translated strings.
   * @since 0.0.1
   */
  load_plugin_textdomain( 'jpdevtools', false, dirname( plugin_basename( __DIR__ ) ) . '/languages' );

  /**
   * Register custom post types enabled
   * @since 0.0.1
   */
  do_action( 'post_types_enabled' );
} );

