<?php
/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Register Product Tag Taxonomy.
 * @since 0.1.0
 */
$labels  = array(
    'name'                       => __( 'Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'singular_name'              => __( 'Product Tag', JPDEVTOOLS_TEXTDOMAIN ),
    'menu_name'                  => __( 'Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'all_items'                  => __( 'All Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'parent_item'                => __( 'Parent Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'parent_item_colon'          => __( 'Parent Product Tags:', JPDEVTOOLS_TEXTDOMAIN ),
    'new_item_name'              => __( 'New Product Tags Name', JPDEVTOOLS_TEXTDOMAIN ),
    'add_new_item'               => __( 'Add New Item', JPDEVTOOLS_TEXTDOMAIN ),
    'edit_item'                  => __( 'Edit Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'update_item'                => __( 'Update Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'view_item'                  => __( 'View Item', JPDEVTOOLS_TEXTDOMAIN ),
    'separate_items_with_commas' => __( 'Separate items with commas', JPDEVTOOLS_TEXTDOMAIN ),
    'add_or_remove_items'        => __( 'Add or remove items', JPDEVTOOLS_TEXTDOMAIN ),
    'choose_from_most_used'      => __( 'Choose from the most used', JPDEVTOOLS_TEXTDOMAIN ),
    'popular_items'              => __( 'Popular Items', JPDEVTOOLS_TEXTDOMAIN ),
    'search_items'               => __( 'Search Product Tags', JPDEVTOOLS_TEXTDOMAIN ),
    'not_found'                  => __( 'Not Found', JPDEVTOOLS_TEXTDOMAIN ),
    'no_terms'                   => __( 'No items', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list'                 => __( 'Items list', JPDEVTOOLS_TEXTDOMAIN ),
    'items_list_navigation'      => __( 'Items list navigation', JPDEVTOOLS_TEXTDOMAIN ),
);
$rewrite = array(
    'slug'         => _x( 'product-tag', 'taxonomy slug', JPDEVTOOLS_TEXTDOMAIN ),
    'with_front'   => false,
    'hierarchical' => true,
);
$args    = array(
    'labels'            => $labels,
    'hierarchical'      => false,
    'public'            => true,
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud'     => true,
    'rewrite'           => $rewrite,
);
register_taxonomy( 'product_cat', array( 'product' ), $args );
