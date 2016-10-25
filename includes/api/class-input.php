<?php

class Input {

  public function get($name) {
    return new InputData($_GET[$name]);
  }

  public function post($name) {
    return new InputData($_POST[$name]);
  }
}
