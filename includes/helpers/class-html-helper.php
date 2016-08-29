<?php

namespace JPDevTools\Helpers;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * HtmlHelper class
 *
 * Based on Laravel Forms & HTML helper and Yii Framework BaseHtml helper
 *
 * @package Core
 *
 * @since   0.0.1
 * @see     https://laravelcollective.com/docs/master/html
 * @see     http://www.yiiframework.com/doc-2.0/yii-helpers-basehtml.html
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Html_Helper {

  /**
   * @see http://w3c.github.io/html/syntax.html#void-elements
   *
   * @var array List of void elements.
   */
  public static $void = array(
      'area', 'base', 'br', 'col', 'embed', 'hr',
      'img', 'input', 'link', 'menuitem', 'meta', 'param',
      'source', 'track', 'wbr'
  );

  /**
   * @var array The preferred order of attributes in a tag.
   */
  public static $attribute_order = array(
      'type', 'id', 'class', 'name', 'value', 'href',
      'src', 'action', 'method', 'selected', 'checked', 'readonly',
      'disabled', 'multiple', 'size', 'maxlength', 'width', 'height',
      'rows', 'cols', 'alt', 'title', 'rel', 'media',
  );

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
      $src = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
    }
    $attributes = wp_parse_args( $attributes, compact( 'src' ) );

    return self::tag( 'img', null, $attributes );
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

    return self::tag( 'script', null, $attributes );
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

    return self::tag( 'link', null, $attributes );
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
  public static function a( $href, $text = '', $attributes = array() ) {
    $text                = is_null( $text ) ? esc_url( $href ) : trim( $text );
    $attributes ['href'] = $href;

    return self::tag( 'a', $text, $attributes );
  }

  /**
   * Convert an array to HTML attributes
   *
   * @since   0.0.1
   *
   * @param   array|string        $attributes
   * @return  string
   */
  public static function attributes( $attributes = array() ) {
    $attributes = wp_parse_args( $attributes );

    if ( count( $attributes ) > 1 ) {
      $sorted = [ ];
      foreach ( static::$attribute_order as $name ) {
        if ( isset( $attributes[$name] ) ) {
          $sorted[$name] = $attributes[$name];
        }
      }
      $attributes = array_merge( $sorted, $attributes );
    }

    $_attributes = array();

    foreach ( (array) $attributes as $key => $value ) {
      if ( is_numeric( $key ) ) {
        $key = $value;
      }

      if ( is_bool( $value ) && $value ) {
        $key = $value;
      }

      if ( !is_null( $value ) ) {
        $_attributes[] = sprintf( '%s="%s"', trim( esc_attr( $key ) ), trim( esc_attr( $value ) ) );
      }
    }

    return implode( ' ', $_attributes );
  }

  /**
   * Retrieve a HTML complete tag
   *
   * @since   0.0.1
   *
   * @param   string              $tag
   * @param   string              $text
   * @param   array|string        $attributes
   * @return  string
   */
  public static function tag( $tag, $text = '', $attributes = array() ) {
    self::parse_shorthand( $tag, $attributes );

    $attributes = self::attributes( $attributes );

    if ( in_array( $tag, self::$void ) ) {
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
  public static function mailto( $email, $text = null, $attributes = array() ) {
    $email = self::email( $email );
    $text  = $text ?: $email;
    $email = self::obfuscate( 'mailto:' ) . $email;

    $defaults   = array(
        'href' => $email
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return self::tag( 'a', $text, $attributes );
  }

  /**
   * Obfuscate an e-mail address to prevent spam-bots from sniffing it.
   *
   * @since   0.0.1
   *
   * @param   string              $email
   * @return  string
   */
  public static function email( $email ) {
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

  /**
   * Check if exists a class in atts, if not then add to string.
   *
   * @since   0.0.1
   *
   * @param   array               $attributes
   * @param   string              $class
   */
  public static function add_css_class( &$attributes = array(), $class ) {

    if ( !isset( $attributes['class'] ) ) {
      $attributes['class'] = $class;
    }
    $current             = explode( ' ', $attributes['class'] );
    $class               = explode( ' ', $class );
    $classes             = array_unique( array_merge( $current, $class ) );
    $attributes['class'] = trim( implode( ' ', $classes ) );
  }

  /**
   * Retrieve a HTML open tag
   *
   * @since   0.0.1
   *
   * @param   string              $tag
   * @param   array|string        $attributes
   * @return  string
   */
  public static function open_tag( $tag, $attributes = array() ) {

    $attributes = wp_parse_args( $attributes );
    self::parse_shorthand( $tag, $attributes );
    $attributes = self::attributes( $attributes );

    return sprintf( '<%s>', trim( $tag . ' ' . $attributes ) );
  }

  /**
   * Retrieve a HTML close tag
   *
   * @since   0.0.1
   *
   * @param   string              $tag
   * @return  string
   */
  public static function close_tag( $tag ) {

    return sprintf( '</$s>', trim( esc_attr( $tag ) ) );
  }

  /**
   * Parse a shorthand tag.
   *
   * @since   0.0.1
   *
   * @param   string              $text
   * @return  array
   */
  public static function parse_shorthand( &$tag, &$attributes = array() ) {
    $matches = array();
    preg_match( '(#|\.)', $tag, $matches );

    if ( empty( $matches ) ) {
      // isn't shorthand, do nothing
      return;
    }

    $items = str_replace( array( '.', '#' ), array( ' .', ' #' ), $tag );
    $items = explode( ' ', $items );

    $tag   = $items[0];
    $id    = null;
    $class = null;

    foreach ( $items as $item ) {
      if ( strpos( $item, '#' ) !== false ) {
        $id = trim( str_replace( '#', '', $item ) );
      } elseif ( strpos( $item, '.' ) !== false ) {
        $class .= ' ' . trim( str_replace( '.', '', $item ) );
      }
    }

    if ( $id && empty( $attributes['id'] ) ) {
      $attributes['id'] = $id;
    }

    if ( $class ) {
      self::add_css_class( $attributes, $class );
    }
  }

  public static function ul( $items, $attributes = array() ) {
    $html = '';

    if ( !is_array( $items ) || count( $items ) == 0 ) {
      return $html;
    }

    foreach ( $items as $key => $value ) {
      if ( is_array( $value ) ) {
        $value = $key . self::ul( $value );
      }
      $html .= self::tag( 'li', $value );
    }

    return self::tag( 'ul', $html, $attributes );
  }

  public static function ol( $items, $attributes = array() ) {
    $html = '';

    if ( count( $items ) == 0 ) {
      return $html;
    }

    foreach ( $items as $key => $value ) {
      if ( is_array( $value ) ) {
        $value = $key . self::ul( $value );
      }
      $html .= self::tag( 'li', $value );
    }

    return self::tag( 'ul', $html, $attributes );
  }

}
