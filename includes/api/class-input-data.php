<?php

class InputData extends Sanitizer {

  private $raw;

  public function __construct( $raw ) {
    $this->raw       = $raw;
    $this->sanitizer = new Sanitizer();
  }

  public function __toString() {
    return (string) $this->raw;
  }

}
