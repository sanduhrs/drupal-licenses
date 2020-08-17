<?php

namespace Drupal\licenses\Controller;

use Composer\Spdx\SpdxLicenses;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Returns responses for Licenses routes.
 */
class LicensesController extends ControllerBase {

  const SPDX_LICENSES_URL = 'https://spdx.org/licenses/licenses.json';

  const SPDX_LICENSE_DETAILS_URL = 'https://spdx.org/licenses/{{ identifier }}.json';

  /**
   * The SPDX Licenses object.
   *
   * @var \Composer\Spdx\SpdxLicenses
   */
  protected $spdxLicenses;

  /**
   * License details.
   *
   * @var array
   */
  protected $licenseDetails;

  /**
   * LicensesController constructor.
   */
  public function __construct() {
    $this->spdxLicenses = new SpdxLicenses();
  }

  /**
   * Builds the response.
   */
  public function build() {
    $licenses = [];
    $licensePluginManager = \Drupal::service('plugin.manager.license');
    $licensePluginDefinitions = $licensePluginManager->getDefinitions();
    foreach ($licensePluginDefinitions as $pluginDefinition) {
      $plugin = $licensePluginManager->createInstance($pluginDefinition['id']);
      $licenses = array_merge($licenses, $plugin->scan());
    }

    $build['overview'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Licences overview'),
      '#markup' => '<p>' . $this->t('The following table provides an overview of the used licenses in this software and whether they are approved by the <a href="https://opensource.org/">Open Source Initiative</a> (OSI) to conform to the <a href="https://opensource.org/docs/osd">Open Source Definition</a> and provide software freedom.') . '</p>',
    ];

    $build['license'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Libraries and licences'),
      '#markup' => '<p>' . $this->t("A list of all used libraries in this software with it's associated license grouped by license identifier.") . '</p>',
    ];

    $build['overview']['toggle-top'] = [
      '#markup' => '<div><a class="licenses--license-toggle-all" href="#">' . $this->t('Toggle all') . '</a></div>',
    ];
    $build['overview']['table'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Name'),
        $this->t('Identifier'),
        $this->t('OSI-approved'),
        $this->t('Usage count'),
        '',
        '',
      ],
      '#rows' => [],
      '#footer' => [],
    ];
    $build['license']['toggle-bottom'] = [
      '#markup' => '<a class="licenses--license-toggle-all" href="#">' . $this->t('Toggle all') . '</a>',
    ];

    $is_osi_string = $this->t('Yes, is OSI certified');
    $not_osi_string = $this->t('No, is not OSI certified');

    /** @var \Drupal\licenses\License $license */
    foreach ($licenses as $license) {
      $build['overview']['table']['#rows'][$license->getIdentifier()] = [
        Link::fromTextAndUrl($license->getFullName(), Url::fromUserInput('#' . $license->getIdentifier())),
        $license->getIdentifier(),
        $license->isOsiCertified() ? $is_osi_string : $not_osi_string,
        0,
        [
          'data' => Link::fromTextAndUrl($this->t('Toggle license text'), Url::fromUserInput('#')),
          'class' => ['licenses--full-license-link'],
        ],
        $license->getUri() ? Link::fromTextAndUrl($this->t('Go to license'), Url::fromUri($license->getUri(), ['external' => TRUE])) : '',
      ];

      if (!isset($this->licenseDetails[$license->getIdentifier()])) {
        $this->licenseDetails[$license->getIdentifier()] = '';
        if ($this->spdxLicenses->getLicenseByIdentifier($license->getIdentifier())) {
          $uri = str_replace('{{ identifier }}', $license->getIdentifier(), self::SPDX_LICENSE_DETAILS_URL);

          $this->licenseDetails[$license->getIdentifier()] = json_decode(
            file_get_contents(str_replace('{{ identifier }}', $license->getIdentifier(), self::SPDX_LICENSE_DETAILS_URL)),
            TRUE
          );
        }
      }

      $build['overview']['table']['#rows'][$license->getIdentifier() . '-license-text'] = [
        'class' => ['licenses--license-text'],
        'data' => [
          [
            'data' => isset($this->licenseDetails[$license->getIdentifier()]['licenseText']) ? $this->licenseDetails[$license->getIdentifier()]['licenseText'] : '',
            'colspan' => 6,
          ],
        ],
      ];

      $build['license'][$license->getIdentifier()] = [
        '#markup' => '<a name="' . $license->getIdentifier() . '"></a>',
      ];
      $build['license'][$license->getIdentifier()]['details'] = [
        '#type' => 'details',
        '#title' => $this->t('@full_name', ['@full_name' => $license->getFullName()]),
      ];
      $build['license'][$license->getIdentifier()]['details']['table'] = [
        '#type' => 'table',
        '#header' => [
          $this->t('Library Name'),
          $this->t('Library Version'),
          $this->t('License Identifier'),
          '',
          '',
        ],
        '#rows' => [],
      ];
    }

    foreach ($licenses as $license) {
      $build['overview']['table']['#rows'][$license->getIdentifier()][3]++;
      array_push(
        $build['license'][$license->getIdentifier()]['details']['table']['#rows'],
        [
          'data' => [
            $license->getLibraryName(),
            $license->getLibraryVersion(),
            $license->getIdentifier(),
            $license->getLibraryHomepage() ? Link::fromTextAndUrl(
              $this->t('Go to library'),
              Url::fromUri(
                $license->getLibraryHomepage(),
                ['external' => TRUE]
              )
            ) : '',
          ],
          'class' => ['licenses--license-information'],
        ]
      );
    }
    $build['#attached']['library'][] = 'licenses/licenses';

    return $build;
  }

}
