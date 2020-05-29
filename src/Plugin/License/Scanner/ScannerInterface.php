<?php

namespace Drupal\licenses\Plugin\License\Scanner;

/**
 * Interface Scanner.
 *
 * @package Drupal\licenses\Plugin\License\Scanner
 */
interface ScannerInterface {

  /**
   * Scan the system for libraries.
   *
   * @return \Drupal\licenses\License[]
   *   An array of library objects.
   */
  public function scan();

}
