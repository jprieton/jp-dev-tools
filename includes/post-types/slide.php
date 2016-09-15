<?php

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Register Carousel Post Type.
 * @since 0.1.0
 */
$labels  = array(
    'name'                  => __( 'Carousel', JPDEVTOOLS_TEXTDOMAIN ),
    'singular_name'         => __( 'Carousel', JPDEVTOOLS_TEXTDOMAIN ),
    'menu_name'             => __( 'Carousel', JPDEVTOOLS_TEXTDOMAIN ),
    'name_admin_bar'        => __( 'Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'archives'              => __( 'Item Archives', JPDEVTOOLS_TEXTDOMAIN ),
    'all_items'             => __( 'All Slides', JPDEVTOOLS_TEXTDOMAIN ),
    'add_new_item'          => __( 'Add New Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'add_new'               => __( 'New Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'new_item'              => __( 'New Item', JPDEVTOOLS_TEXTDOMAIN ),
    'edit_item'             => __( 'Edit Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'update_item'           => __( 'Update Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'view_item'             => __( 'View Slide', JPDEVTOOLS_TEXTDOMAIN ),
    'search_items'          => __( 'Search slide', JPDEVTOOLS_TEXTDOMAIN ),
    'not_found'             => __( 'No slide found', JPDEVTOOLS_TEXTDOMAIN ),
    'not_found_in_trash'    => __( 'No slide found in Trash', JPDEVTOOLS_TEXTDOMAIN ),
    'insert_into_item'      => __( 'Insert into item', JPDEVTOOLS_TEXTDOMAIN ),
    'uploaded_to_this_item' => __( 'Uploaded to this item', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list'            => __( 'Items list', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list_navigation' => __( 'Items list navigation', JPDEVTOOLS_TEXTDOMAIN ),
    'filter_items_list'     => __( 'Filter items list', JPDEVTOOLS_TEXTDOMAIN ),
);
$rewrite = array(
    'slug'       => _x( 'carousel', 'post_type slug', JPDEVTOOLS_TEXTDOMAIN ),
    'with_front' => true,
    'pages'      => true,
    'feeds'      => true,
);
$args    = array(
    'label'               => __( 'Carousel', JPDEVTOOLS_TEXTDOMAIN ),
    'description'         => __( 'Site Carousel', JPDEVTOOLS_TEXTDOMAIN ),
    'labels'              => $labels,
    'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', ),
    'hierarchical'        => false,
    'public'              => false,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-format-gallery',
    'show_in_admin_bar'   => false,
    'show_in_nav_menus'   => false,
    'can_export'          => true,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'publicly_queryable'  => false,
    'rewrite'             => $rewrite,
    'capability_type'     => 'post',
);
register_post_type( 'slide', $args );
