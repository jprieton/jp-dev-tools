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
 * Based on Laravel Forms & HTML
 *
 * @package Core
 *
 * @since   0.0.1
 * @see     https://laravelcollective.com/docs/master/html
 *
 * @author  jprieton
 */
class HTML {

  /**
   * Retrieve an HTML img element
   *
   * @since 0.0.1
   *
   * @param   string              $src
   * @param   string|array        $attributes
   *
   * @see     http://png-pixel.com/
   *
   * @return  string
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
   * Retrieve an HTML script element
   *
   * @since 0.0.1
   *
   * @param   string              $src
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function script( $src, $attributes = array() ) {
    $attributes = wp_parse_args( $attributes, compact( 'src' ) );

    return self::_tag( 'script', null, $attributes );
  }

  /**
   * Retrieve an HTML style element
   *
   * @since 0.0.1
   *
   * @param   string              $href
   * @param   string|array        $attributes
   *
   * @return  string
   */
  public static function style( $href, $attributes = array() ) {
    $defaults   = array(
        'href'  => $href,
        'rel'   => 'stylesheet',
        'type'  => 'text/css',
        'media' => 'all',
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_tag( 'link', null, $attributes );
  }

  /**
   * Retrieve a HTML link
   *
   * @since   0.0.1
   *
   * @param   string              $href
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function link( $href, $text = '', $attributes = array() ) {
    $text                = is_null( $text ) ? esc_url( $href ) : trim( $text );
    $attributes ['href'] = $href;

    return self::_tag( 'a', $text, $attributes );
  }

  /**
   * Convert an array to HTML attributes
   *
   * @since   0.0.1
   *
   * @param   array|string        $attributes
   * @return  string
   */
  public static function _attributes( $attributes = array() ) {
    $_attributes = array();
    foreach ( (array) $attributes as $key => $value ) {
      if ( is_numeric( $key ) ) {
        $_attributes[] = esc_attr( trim( $value ) );
      } else {
        $_attributes[] = trim( $key ) . '="' . trim( esc_attr( $value ) ) . '"';
      }
    }

    return implode( ' ', $_attributes );
  }

  /**
   * Retrieve a HTML tag
   *
   * @since   0.0.1
   *
   * @param   string              $tag
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function _tag( $tag, $text = '', $attributes = array() ) {
    $self_closing = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta' );

    $attributes = self::_attributes( $attributes );

    if ( in_array( $tag, $self_closing ) ) {
      $html = sprintf( '<%s />', trim( $tag . ' ' . $attributes ) );
    } else {
      $html = sprintf( '<%s>%s</%s>', trim( $tag . ' ' . $attributes ), $text, $tag );
    }

    return $html;
  }

  /**
   * Generate a HTML link to an email address.
   *
   * @since   0.0.1
   *
   * @param   string              $email
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public function mailto( $email, $text = null, $attributes = array() ) {
    $email = self::email( $email );
    $text  = $text ?: $email;
    $email = self::obfuscate( 'mailto:' ) . $email;

    $defaults   = array(
        'href' => $email
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::_tag( 'a', $text, $attributes );
  }

  /**
   * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
   *
   * @since   0.0.1
   *
   * @param   string              $email
   * @return  string
   */
  public function email( $email ) {
    return str_replace( '@', '&#64;', self::obfuscate( $email ) );
  }

  /**
   * Obfuscate a string to prevent spam-bots from sniffing it.
   *
   * @since   0.0.1
   *
   * @param   string              $text
   * @return  string
   */
  public static function obfuscate( $text ) {
    $safe = '';
    foreach ( str_split( $text ) as $letter ) {
      if ( ord( $letter ) > 128 ) {
        return $letter;
      }
      // To properly obfuscate the value, we will randomly convert each letter to
      // its entity or hexadecimal representation, keeping a bot from sniffing
      // the randomly obfuscated letters out of the string on the responses.
      switch ( rand( 1, 3 ) ) {
        case 1:
          $safe .= '&#' . ord( $letter ) . ';';
          break;
        case 2:
          $safe .= '&#x' . dechex( ord( $letter ) ) . ';';
          break;
        case 3:
          $safe .= $letter;
      }
    }
    return $safe;
  }

}
