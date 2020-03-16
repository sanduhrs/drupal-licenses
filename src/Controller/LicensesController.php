<?php

namespace Drupal\licenses\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Core\Asset\LibraryDiscoveryInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ModuleHandler;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Returns responses for Licenses routes.
 */
class LicensesController extends ControllerBase {

  /**
   * The library discovery service.
   *
   * @var \Drupal\Core\Asset\LibraryDiscoveryInterface
   */

  /**
   * The module handler service.
   *
   * @var \Drupal\Core\Extension\ModuleHandler
   */
  protected $moduleHandler;

  /**
   * LicensesController constructor.
   *
   * @param \Drupal\Core\Asset\LibraryDiscoveryInterface $library_discovery
   * @param \Drupal\Core\Extension\ModuleHandler $module_handler
   */
  public function __construct(LibraryDiscoveryInterface $library_discovery, ModuleHandler $module_handler) {
    $this->libraryDiscovery = $library_discovery;
    $this->moduleHandler = $module_handler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('library.discovery'),
      $container->get('module_handler')
    );
  }

  /**
   * Builds the response.
   */
  public function build() {
    $modules = $this->moduleHandler->getModuleList();
    foreach ($modules as $machine_name => $module) {
      $form[$machine_name] = [
        '#type' => 'fieldset',
        '#title' => $this->t($module->getName()),
      ];
      $libraries = $this->libraryDiscovery->getLibrariesByExtension($machine_name);
      foreach ($libraries as $library_machine_name => $library) {
        $form[$machine_name][$library_machine_name] = [
          '#type' => 'fieldset',
          '#title' => $this->t('@machine_name/@library_machine_name v@version: @license', [
            '@machine_name' => $machine_name,
            '@library_machine_name' => $library_machine_name,
            '@version' => $library['version'],
            '@license' => $library['license']['name'],
          ]),
        ];
        if (isset($library['license']['url'])) {
          $form[$machine_name][$library_machine_name]['license'] = [
            '#markup' => '<pre>' . print_r($library, TRUE) . '</pre>',
          ];
          break;
        }
      }
    }
    $computed_settings = [
      'foo' => 'bar',
      'baz' => 'qux',
    ];
    $form['#attached']['library'][] = 'licenses/licenses';
    $form['#attached']['drupalSettings']['licenses']['licenses'] = $computed_settings;

    $build['overview']['title'] = [
      '#markup' => '<h2>' . $this->t('Overview') . '</h2>',
    ];
    $build['overview']['table'] = [
      '#type' => 'table',
      '#header' => [
        $this->t('Name'),
        $this->t('Identifier'),
        $this->t('Osi approved'),
        $this->t('Count'),
        $this->t('License text'),
      ],
      '#rows' => [
        [
          Link::fromTextAndUrl($this->t('GNU General Public License v2.0 or later'), Url::fromUserInput('#GPL-2.0-or-later')),
          $this->t('GPL-2.0-or-later'),
          $this->t('Yes'),
          $this->t('@count', ['@count' => 25]),
          Link::fromTextAndUrl($this->t('License text'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
        ],
        [
          Link::fromTextAndUrl($this->t('BSD 3-Clause "New" or "Revised" License'), Url::fromUserInput('#BSD-3-Clause')),
          $this->t('BSD-3-Clause'),
          $this->t('Yes'),
          $this->t('@count', ['@count' => 12]),
          Link::fromTextAndUrl($this->t('License text'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
        ],
      ],
    ];

    $licenses = [
      [
        'full_name' => 'GNU General Public License v2.0 or later',
        'identifier' => 'GPL-2.0-or-later',
        'osi_approved' => TRUE,
        'deprecated' => FALSE,
        'libraries' => [
          [
            'data' => [
              $this->t('drupal/core'),
              $this->t('8.8.3'),
              $this->t('GPL-2.0-or-later'),
              [
                'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#')),
                'class' => ['full-license-link'],
              ],
              Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
            ],
            'class' => ['license-information'],
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
          [
            $this->t('drush/drush'),
            $this->t('8.8.3'),
            $this->t('GPL-2.0-or-later'),
            [
              'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#')),
              'class' => ['full-license-link'],
            ],
            Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
          [
            $this->t('league/container'),
            $this->t('8.8.3'),
            $this->t('GPL-2.0-or-later'),
            [
              'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#')),
              'class' => ['full-license-link'],
            ],
            Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
        ],
      ],
      [
        'full_name' => 'BSD 3-Clause "New" or "Revised" License',
        'identifier' => 'BSD-3-Clause',
        'osi_approved' => TRUE,
        'deprecated' => FALSE,
        'libraries' => [
          [
            $this->t('drupal/core'),
            $this->t('8.8.3'),
            $this->t('BSD-3-Clause'),
            [
              'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#')),
              'class' => ['full-license-link'],
            ],
            Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
          [
            $this->t('drush/drush'),
            $this->t('8.8.3'),
            $this->t('BSD-3-Clause'),
            [
              'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#')),
              'class' => ['full-license-link'],
            ],
            Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
          [
            $this->t('league/container'),
            $this->t('8.8.3'),
            $this->t('BSD-3-Clause'),
            [
              'data' => Link::fromTextAndUrl($this->t('License text'), Url::fromUserInput('#license')),
              'class' => ['full-license-link'],
            ],
            Link::fromTextAndUrl($this->t('External link'), Url::fromUri('http://www.example.com', ['external' => TRUE])),
          ],
          [
            'data' => [
              [
                'data' => Html::escape(@file_get_contents(drupal_get_path('module', 'licenses') . '/LICENSE.txt')),
                'colspan' => 5,
              ],
            ],
            'class' => ['preformatted', 'full-license-text'],
          ],
        ],
      ],
    ];
    foreach ($licenses as $license) {
      $build['license'][$license['identifier']]['title'] = [
        '#markup' => '<h2 id="' . $license['identifier'] . '">' . $this->t('@full_name', ['@full_name' => $license['full_name']]) . '</h2>',
      ];
      $build['license'][$license['identifier']]['table'] = [
        '#type' => 'table',
        '#header' => [
          $this->t('Name'),
          $this->t('Version'),
          $this->t('Identifier'),
          $this->t('License link'),
          $this->t('External link'),
        ],
        '#rows' => $license['libraries'],
      ];
    }
    $build['#attached']['library'][] = 'licenses/licenses';
    return $build;
  }

}
