<?php

namespace JPDevTools\PostTypes;

use JPDevTools\Abstracts\PostType;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * PostTypeSlider class
 *
 * @package PostTypeSlider
 * @since 0.0.1
 * @author jprieton
 */
class PostTypeSlider extends PostType {

  public static function custom_post_type() {
    $labels = array(
        'name'                  => _x( 'Sliders', 'Post Type General Name', 'jpdevtools' ),
        'singular_name'         => _x( 'Slider', 'Post Type Singular Name', 'jpdevtools' ),
        'menu_name'             => __( 'Sliders', 'jpdevtools' ),
        'name_admin_bar'        => __( 'Slider', 'jpdevtools' ),
        'archives'              => __( 'Item Archives', 'jpdevtools' ),
        'parent_item_colon'     => __( 'Parent Item:', 'jpdevtools' ),
        'all_items'             => __( 'All Items', 'jpdevtools' ),
        'add_new_item'          => __( 'Add New Item', 'jpdevtools' ),
        'add_new'               => __( 'Add New', 'jpdevtools' ),
        'new_item'              => __( 'New Item', 'jpdevtools' ),
        'edit_item'             => __( 'Edit Item', 'jpdevtools' ),
        'update_item'           => __( 'Update Item', 'jpdevtools' ),
        'view_item'             => __( 'View Item', 'jpdevtools' ),
        'search_items'          => __( 'Search Item', 'jpdevtools' ),
        'not_found'             => __( 'Not found', 'jpdevtools' ),
        'not_found_in_trash'    => __( 'Not found in Trash', 'jpdevtools' ),
        'featured_image'        => __( 'Featured Image', 'jpdevtools' ),
        'set_featured_image'    => __( 'Set featured image', 'jpdevtools' ),
        'remove_featured_image' => __( 'Remove featured image', 'jpdevtools' ),
        'use_featured_image'    => __( 'Use as featured image', 'jpdevtools' ),
        'insert_into_item'      => __( 'Insert into item', 'jpdevtools' ),
        'uploaded_to_this_item' => __( 'Uploaded to this item', 'jpdevtools' ),
        'items_list'            => __( 'Items list', 'jpdevtools' ),
        'items_list_navigation' => __( 'Items list navigation', 'jpdevtools' ),
        'filter_items_list'     => __( 'Filter items list', 'jpdevtools' ),
    );

    $args = array(
        'label'               => __( 'Slider', 'jpdevtools' ),
        'description'         => __( 'Slider post type', 'jpdevtools' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields', ),
        'hierarchical'        => false,
        'public'              => false,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-format-gallery',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => false,
        'can_export'          => true,
        'has_archive'         => false,
        'exclude_from_search' => true,
        'publicly_queryable'  => false,
        'rewrite'             => false,
        'capability_type'     => 'post',
    );

    register_post_type( 'slider', $args );
  }

}
