<?php

namespace JPDevTools;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * HTML class
 *
 * @package Core
 * @since 0.0.1
 * @author jprieton
 */
class HTML {

  /**
   * Get an HTML img element
   *
   * @since 0.0.1
   *
   * @param   string              $src
   * @param   string|array        $attributes
   *
   * @see http://png-pixel.com/
   * @return string
   */
  public static function image( $src, $attributes = array() ) {
    if ( 'pixel' == $src ) {
      $src        = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
      $attributes = array_merge( array( 'alt' => 'Pixel' ), (array) $attributes );
    }
    $attributes = wp_parse_args( $attributes, compact( 'src' ) );
    return self::_tag( 'img', null, $attributes );
  }

  /**
   * Convert an array to HTML attributes
   *
   * @since   0.0.1
   *
   * @param   string|array        $attributes
   * @return  string
   */
  public static function _attributes( $attributes = array() ) {
    $_attr = array();
    foreach ( (array) $attributes as $key => $value ) {
      if ( is_numeric( $key ) ) {
        $_attr[] = esc_attr( trim( $value ) );
      } else {
        $_attr[] = trim( $key ) . '="' . trim( esc_attr( $value ) ) . '"';
      }
    }
    return implode( ' ', $_attr );
  }

  /**
   * Returns a HTML tag
   *
   * @since   0.0.1
   *
   * @param   string         $tag
   * @param   string         $content
   * @param   array          $attributes
   * @return  string
   */
  public static function _tag( $tag, $content = '', $attributes = array() ) {
    $self_closing = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta' );

    $attributes = self::_attributes( $attributes );

    if ( in_array( $tag, $self_closing ) ) {
      $html = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html = sprintf( '<%s>%s</%s>', trim( $tag . ' ' . $attributes ), $content, $tag );
    }
    return (string) $html;
  }

}
