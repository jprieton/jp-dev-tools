<?php

namespace JPDevTools\Vendor\Bootstrap;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

use JPDevTools\Helpers\HtmlHelper as Html;
use JPDevTools\Helpers\ArrayHelper;

/**
 * Pagination class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.1.0
 * @see            http://getbootstrap.com/components/#pagination
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Pagination {

  /**
   * Returns a Bootstrap pagination links
   *
   * @since  0.1.0
   * @see    https://codex.wordpress.org/Function_Reference/paginate_links
   *
   * @global  type          $wp_query
   * @param   array         $args
   * @return  string
   */
  public static function paginate_links( $args = array() ) {
    $defaults  = array(
        'nav_class' => 'text-center',
        'class'     => '',
        'prev_text' => '<span aria-hidden="true">&laquo;</span>',
        'next_text' => '<span aria-hidden="true">&raquo;</span>',
        'type'      => 'list',
    );
    $args      = wp_parse_args( $args, $defaults );
    $nav_class = ArrayHelper::extract( $args, 'nav_class', 'text-center' );

    $paginate   = paginate_links( $args );
    $search     = array(
        "<ul class='page-numbers'>",
        "<li><span class='page-numbers current'>"
    );
    $replace    = array(
        "<ul class='page-numbers pagination'>",
        "<li class='active'><span class='page-numbers current'>"
    );
    $paginate   = str_replace( $search, $replace, $paginate );
    $pagination = Html::tag( 'nav', $paginate, array(
                'itemscope',
                'itemtype' => 'http://schema.org/SiteNavigationElement',
                'class'    => $nav_class ) );

    return $paginate;
  }

}
