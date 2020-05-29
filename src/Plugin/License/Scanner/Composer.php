<?php

namespace Drupal\licenses\Plugin\License\Scanner;

use Composer\Spdx\SpdxLicenses;
use Drupal\licenses\License;
use Drupal\licenses\LicensePluginBase;

/**
 * Plugin implementation of the license.
 *
 * @License(
 *   id = "composer",
 *   label = @Translation("Composer"),
 *   description = @Translation("Composer installed libraries licenses.")
 * )
 */
class Composer extends LicensePluginBase implements ScannerInterface {

  const COMPOSER_INSTALLED_FILE = DRUPAL_ROOT . '/../vendor/composer/installed.json';

  /**
   * An array of licenses.
   *
   * @var \Drupal\licenses\License[]
   */
  protected $licenses = [];

  /**
   * {@inheritDoc}
   */
  public function scan() {
    $spdx = new SpdxLicenses();

    $path = self::COMPOSER_INSTALLED_FILE;
    $installed = json_decode(file_get_contents($path), TRUE);

    foreach ($installed as $library) {
      $license = new License();
      $identifier = (string) @$library['license'][0];
      $spdx_license = $spdx->getLicenseByIdentifier($identifier);

      $license
        ->setIdentifier($identifier)
        ->setLibraryName((string) @$library['name'])
        ->setLibraryVersion((string) @$library['version'])
        ->setLibraryHomepage((string) @$library['homepage'])
        ->setLibraryDescription((string) @$library['description']);
      if (isset($spdx_license)) {
        $license
          ->setFullName((string) $spdx_license[0])
          ->setOsiCertified((bool) $spdx_license[1])
          ->setUri((string) $spdx_license[2])
          ->setDeprecated((bool) $spdx_license[3]);
      }
      array_push($this->licenses, $license);
    }
    return $this->licenses;
  }

}
