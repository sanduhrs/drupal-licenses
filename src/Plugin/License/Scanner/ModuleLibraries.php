<?php

namespace Drupal\licenses\Plugin\License\Scanner;

use Composer\Spdx\SpdxLicenses;
use Drupal\licenses\License;
use Drupal\licenses\LicensePluginBase;

/**
 * Plugin implementation of the license.
 *
 * @License(
 *   id = "module_libraries",
 *   label = @Translation("Module libraries"),
 *   description = @Translation("Drupal module defined libraries licenses.")
 * )
 */
class ModuleLibraries extends LicensePluginBase implements ScannerInterface {

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
    $modules = \Drupal::moduleHandler()->getModuleList();

    // Fake core as a module.
    $modules = ['core' => []] + $modules;

    foreach ($modules as $machine_name => $module) {
      $libraries = \Drupal::service('library.discovery')
        ->getLibrariesByExtension($machine_name);

      foreach ($libraries as $library_machine_name => $library) {
        $license = new License();
        $identifier = str_replace('GNU-', '', (string) @$library['license']['name']);
        $spdx_license = $spdx->getLicenseByIdentifier($identifier);

        $license
          ->setIdentifier($identifier)
          ->setLibraryName($machine_name . '/' . $library_machine_name)
          ->setLibraryVersion((string) @$library['version'])
          ->setLibraryHomepage((string) @$library['remote']);
        if (isset($spdx_license)) {
          $license
            ->setFullName((string) $spdx_license[0])
            ->setOsiCertified((bool) $spdx_license[1])
            ->setUri((string) $spdx_license[2])
            ->setDeprecated((bool) $spdx_license[3]);
        }
        array_push($this->licenses, $license);
      }
    }
    return $this->licenses;
  }

}
