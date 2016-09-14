<?php

namespace JPDevTools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Breadcrumb class
 *
 * @package Core
 * @since 0.1.0
 * @author jprieton
 */
class Breadcrumb {

  private $items = array();

  public function reset() {
    $this->items = array();
  }

  public function add_item( $label, $link = '' ) {
    $this->items[] = array(
        $label,
        $link,
    );
  }

  private function add_item_404() {
    $this->add_item( __( 'Page not found', 'jpdevtools' ) );
  }

  private function add_item_author() {
    global $author;

    $userdata = get_userdata( $author );
    $this->add_item( sprintf( __( 'Author: %s', 'jpdevtools' ), $userdata->display_name ) );
  }

  private function add_item_home() {
    $link = is_paged() ? get_permalink( get_queried_object() ) : '';
    $this->add_item( single_post_title( '', false ), $link );
  }

  private function add_item_page() {
    global $post;

    if ( $post->post_parent ) {
      $parent_crumbs = array();
      $parent_id     = $post->post_parent;

      while ( $parent_id ) {
        $page            = get_post( $parent_id );
        $parent_id       = $page->post_parent;
        $parent_crumbs[] = array( get_the_title( $page->ID ), get_permalink( $page->ID ) );
      }

      $parent_crumbs = array_reverse( $parent_crumbs );

      foreach ( $parent_crumbs as $crumb ) {
        $this->add_item( $crumb[0], $crumb[1] );
      }
    }

    $this->add_item( get_the_title() );
  }

  private function add_item_category() {
    $taxonomy = 'category';
    $term     = get_term_by( 'slug', get_query_var( 'category_name' ), $taxonomy );
    $this->term_ancestors( $term->term_id, $taxonomy );
    $this->add_item( $term->name );
  }

  public function get_breadcrumb() {
    return $this->items;
  }

  private function term_ancestors( $term_id, $taxonomy ) {
    $ancestors = get_ancestors( $term_id, $taxonomy );
    $ancestors = array_reverse( $ancestors );

    foreach ( $ancestors as $ancestor ) {
      $ancestor = get_term( $ancestor, $taxonomy );

      if ( !is_wp_error( $ancestor ) && $ancestor ) {
        $this->add_item( $ancestor->name, get_term_link( $ancestor ) );
      }
    }
  }

  public function generate() {
    $conditionals = array(
        'is_home',
        'is_404',
        'is_attachment',
        'is_single',
        'is_page',
        'is_post_type_archive',
        'is_category',
        'is_tag',
        'is_author',
        'is_date',
        'is_tax'
    );

    foreach ( $conditionals as $conditional ) {
      if ( call_user_func( $conditional ) ) {
        call_user_func( array( $this, 'add_item_' . substr( $conditional, 3 ) ) );
        break;
      }
    }

    if ( !is_404() ) {
      $this->search_trail();
      $this->paged_trail();
    }

    return $this->get_breadcrumb();
  }

  private function paged_trail() {
    if ( get_query_var( 'paged' ) ) {
      $this->add_item( sprintf( __( 'Page %d', 'jpdevtools' ), get_query_var( 'paged' ) ) );
    }
  }

  private function search_trail() {
    if ( is_search() ) {
      $this->add_item( sprintf( __( 'Search results for &ldquo;%s&rdquo;', 'jpdevtools' ), get_search_query() ), remove_query_arg( 'paged' ) );
    }
  }

}
