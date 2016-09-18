<?php

/**
 * Returns the fallback not found image
 * 
 * @since 0.1.0
 * 
 * @return string
 */
function get_not_found_image() {
  $init = JPDevTools\Core\Init\PublicInit::get_instance();
  return $init->get_not_found_image_url();
}
