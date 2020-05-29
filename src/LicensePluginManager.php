<?php

namespace Drupal\licenses;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * License plugin manager.
 */
class LicensePluginManager extends DefaultPluginManager {

  /**
   * Constructs LicensePluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/License',
      $namespaces,
      $module_handler,
      'Drupal\licenses\LicenseInterface',
      'Drupal\licenses\Annotation\License'
    );
    $this->alterInfo('license_info');
    $this->setCacheBackend($cache_backend, 'license_plugins');
  }

}
