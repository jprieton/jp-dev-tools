<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Register Product Post Type.
 * @since 0.1.0
 */
$labels  = array(
    'name'                  => __( 'Services', JPDEVTOOLS_TEXTDOMAIN ),
    'singular_name'         => __( 'Service', JPDEVTOOLS_TEXTDOMAIN ),
    'menu_name'             => __( 'Service', JPDEVTOOLS_TEXTDOMAIN ),
    'name_admin_bar'        => __( 'Service', JPDEVTOOLS_TEXTDOMAIN ),
    'archives'              => __( 'Item Archives', JPDEVTOOLS_TEXTDOMAIN ),
    'parent_item_colon'     => __( 'Parent Service:', JPDEVTOOLS_TEXTDOMAIN ),
    'all_items'             => __( 'All Services', JPDEVTOOLS_TEXTDOMAIN ),
    'add_new_item'          => __( 'Add New Service', JPDEVTOOLS_TEXTDOMAIN ),
    'add_new'               => __( 'New Service', JPDEVTOOLS_TEXTDOMAIN ),
    'new_item'              => __( 'New Item', JPDEVTOOLS_TEXTDOMAIN ),
    'edit_item'             => __( 'Edit Service', JPDEVTOOLS_TEXTDOMAIN ),
    'update_item'           => __( 'Update Service', JPDEVTOOLS_TEXTDOMAIN ),
    'view_item'             => __( 'View Service', JPDEVTOOLS_TEXTDOMAIN ),
    'search_items'          => __( 'Search services', JPDEVTOOLS_TEXTDOMAIN ),
    'not_found'             => __( 'No services found', JPDEVTOOLS_TEXTDOMAIN ),
    'not_found_in_trash'    => __( 'No services found in Trash', JPDEVTOOLS_TEXTDOMAIN ),
    'insert_into_item'      => __( 'Insert into item', JPDEVTOOLS_TEXTDOMAIN ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list'            => __( 'Items list', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list_navigation' => __( 'Items list navigation', JPDEVTOOLS_TEXTDOMAIN ),
    'filter_items_list'     => __( 'Filter items list', JPDEVTOOLS_TEXTDOMAIN ),
);
$rewrite = array(
    'slug'       => _x( 'service', 'post_type slug', JPDEVTOOLS_TEXTDOMAIN ),
    'with_front' => true,
    'pages'      => true,
    'feeds'      => true,
);
$args    = array(
    'label'               => __( 'Service', JPDEVTOOLS_TEXTDOMAIN ),
    'description'         => __( 'Site services.', JPDEVTOOLS_TEXTDOMAIN ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-businessman',
    'show_in_admin_bar'   => true,
    'show_in_nav_menus'   => true,
    'can_export'          => true,
    'has_archive'         => _x( 'service', 'post_type archive_slug', JPDEVTOOLS_TEXTDOMAIN ),
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'post',
);
register_post_type( 'service', $args );

