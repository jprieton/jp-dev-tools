<?php

namespace JPDevTools\Vendor\Bootstrap;

use JPDevTools\Helpers\Html_Helper as Html;
use JPDevTools\Vendor\Bootstrap\Misc;

/**
 * If this file is called directly, abort.
 */
if ( !defined( 'ABSPATH' ) ) {
  die( 'Direct access is forbidden.' );
}

/**
 * Bootstrap modal class
 *
 * @package        Vendor
 * @subpackage     Bootstrap
 *
 * @since          0.0.1
 * @see            http://getbootstrap.com/javascript/#modals
 *
 * @author         Javier Prieto <jprieton@gmail.com>
 */
class Modal {

  /**
   * Modal attributes
   *
   * @since   0.0.1
   *
   * @var array
   */
  private $attributes;

  /**
   * Modal header text
   *
   * @since   0.0.1
   *
   * @var string
   */
  private $header;

  /**
   * Modal footer text
   *
   * @since   0.0.1
   *
   * @var string
   */
  private $footer;

  /**
   * Modal body text
   *
   * @since   0.0.1
   *
   * @var string
   */
  private $body;

  /**
   * Bootstrap modal's constructor
   *
   * @since   0.0.1
   *
   * @param   array|string        $attributes
   */
  public function __construct( $attributes = array() ) {
    static $id;

    if ( is_null( $id ) ) {
      $id = 1;
    } else {
      $id++;
    }

    $defaults         = array(
        'class'    => 'modal',
        'tabindex' => '-1',
        'role'     => 'dialog',
        'id'       => "modal-{$id}",
    );
    $this->attributes = wp_parse_args( $attributes, $defaults );
  }

  /**
   * Set the modal header
   *
   * @since   0.0.1
   *
   * @param   string              $header
   */
  public function set_header( $header ) {
    $this->header = (string) $header;
  }

  /**
   * Set the modal footer
   *
   * @since   0.0.1
   *
   * @param   string              $footer
   */
  public function set_footer( $footer ) {
    $this->footer = (string) $footer;
  }

  /**
   * Set the modal body
   *
   * @since   0.0.1
   *
   * @param   string              $body
   */
  public function set_body( $body ) {
    $this->body = (string) $body;
  }

  /**
   * Retrieve a Bootstrap modal markup
   *
   * @since   0.0.1
   *
   * @param   bool                $echo
   * @return  string
   */
  public function render( $echo = false ) {
    $modal_content = $this->_get_header() . $this->_get_body() . $this->_get_footer();

    $content = '';

    if ( !empty( $modal_content ) ) {
      $content .= Html::open_tag( 'div', $this->attributes );
      $content .= Html::open_tag( 'div.modal-dialog', 'role=document' );
      $content .= Html::tag( 'div.modal-content', $modal_content );
      $content .= Html::close_tag( 'div' );
      $content .= Html::close_tag( 'div' );
    }

    if ( $echo ) {
      echo $content;
    }

    return $content;
  }

  /**
   * Retrieve a Bootstrap modal header markup
   *
   * @since   0.0.1
   *
   * @return  string
   */
  private function _get_header() {
    if ( empty( $this->header ) ) {
      return '';
    }

    $dismiss = Misc::dismiss_button( 'modal' );
    $title   = Html::tag( 'h4.modal-title', $this->header );
    $header  = Html::tag( 'div.modal-header', $dismiss . $title );

    return $header;
  }

  /**
   * Retrieve a Bootstrap modal footer markup
   *
   * @since   0.0.1
   *
   * @return  string
   */
  private function _get_footer() {
    if ( empty( $this->footer ) ) {
      return '';
    }
    
    return Html::tag( 'div.modal-footer', $this->footer );
  }

  /**
   * Retrieve a Bootstrap modal body markup
   *
   * @since   0.0.1
   *
   * @return  string
   */
  private function _get_body() {
    if ( empty( $this->body ) ) {
      return '';
    }

    $body = apply_filters( 'the_content', $this->body );

    return Html::tag( 'div.modal-body', $body );
  }

  /**
   * Retrieve a Bootstrap modal button trigger
   *
   * @since   0.0.1
   *
   * @param   string              $src
   * @param   string|array        $attributes
   * 
   * @return  string
   */
  public function get_button_trigger( $text, $attributes = array() ) {
    $defaults   = array(
        'class'       => 'btn btn-default',
        'data-toogle' => 'modal',
        'data-target' => $this->attributes['id'],
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Html::tag( 'button', $text, $attributes );
  }

  /**
   * Retrieve a Bootstrap modal button trigger
   *
   * @since   0.0.1
   *
   * @param   string              $src
   * @param   string|array        $attributes
   * 
   * @return  string
   */
  public function get_link_trigger( $text, $attributes = array() ) {
    $defaults   = array(
        'href'        => '#',
        'data-toogle' => 'modal',
        'data-target' => $this->attributes['id'],
    );
    $attributes = wp_parse_args( $attributes, $defaults );

    return Html::tag( 'a', $text, $attributes );
  }

}
