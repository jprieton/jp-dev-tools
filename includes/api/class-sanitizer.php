<?php

class Sanitizer {

  private $raw;

  public function __construct( $raw = null ) {
    $this->raw = $raw;
  }

  public function int() {
    $value = !func_num_args() ? $this->raw : current( func_get_args() );
    return (int) $value;
  }

  public function float() {
    $value = !func_num_args() ? $this->raw : current( func_get_args() );
    return (float) $value;
  }

  public function bool() {
    $value = !func_num_args() ? $this->raw : current( func_get_args() );
    return (bool) $value;
  }

  public function text() {
    $value = !func_num_args() ? $this->raw : current( func_get_args() );
    return sanitize_text_field( $value );
  }

  public function email() {
    $value = !func_num_args() ? $this->raw : current( func_get_args() );
    return sanitize_email( $value );
  }

}
