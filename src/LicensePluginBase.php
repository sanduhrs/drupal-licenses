<?php

namespace Drupal\licenses;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for license plugins.
 */
abstract class LicensePluginBase extends PluginBase implements LicenseInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
