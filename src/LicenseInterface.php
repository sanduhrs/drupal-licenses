<?php

namespace Drupal\licenses;

/**
 * Interface for license plugins.
 */
interface LicenseInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
