<?php

namespace Drupal\licenses;

/**
 * Class License.
 *
 * @package Drupal\licenses
 */
class License {

  /**
   * The license identifier.
   *
   * @var string
   */
  protected $identifier;

  /**
   * The license full name.
   *
   * @var string
   */
  protected $fullName;

  /**
   * Is the license osi certified?
   *
   * @var bool
   */
  protected $osiCertified;

  /**
   * Is the license identifier deprecated?
   *
   * @var bool
   */
  protected $deprecated;

  /**
   * The license URI.
   *
   * @var string
   */
  protected $uri;

  /**
   * The library name.
   *
   * @var string
   */
  protected $libraryName;

  /**
   * The library version.
   *
   * @var string
   */
  protected $libraryVersion;

  /**
   * The library homepage.
   *
   * @var string
   */
  protected $libraryHomepage;

  /**
   * The library description.
   *
   * @var string
   */
  protected $libraryDescription;

  /**
   * Get identifier.
   *
   * @return string
   *   The identifier string.
   */
  public function getIdentifier() {
    return $this->identifier;
  }

  /**
   * Set identifier.
   *
   * @param string $identifier
   *   The identifier string.
   *
   * @return License
   *   The license object.
   */
  public function setIdentifier($identifier) {
    $this->identifier = $identifier;
    if (empty($this->fullName)) {
      $this->setFullName($identifier);
    }
    return $this;
  }

  /**
   * Get full name.
   *
   * @return string
   *   The full name string.
   */
  public function getFullName() {
    return $this->fullName;
  }

  /**
   * Set full name.
   *
   * @param string $fullName
   *   The full name string.
   *
   * @return License
   *   The license object.
   */
  public function setFullName($fullName) {
    $this->fullName = $fullName;
    return $this;
  }

  /**
   * Is osi certified?
   *
   * @return bool
   *   A boolean indicator.
   */
  public function isOsiCertified() {
    return $this->osiCertified;
  }

  /**
   * Set is osi certified.
   *
   * @param bool $osiCertified
   *   A boolean indicator.
   *
   * @return License
   *   The license object.
   */
  public function setOsiCertified($osiCertified) {
    $this->osiCertified = $osiCertified;
    return $this;
  }

  /**
   * Is deprecated?
   *
   * @return bool
   *   A boolean indicator.
   */
  public function isDeprecated() {
    return $this->deprecated;
  }

  /**
   * Set is deprecated.
   *
   * @param bool $deprecated
   *   A boolean indicator.
   *
   * @return License
   *   The license object.
   */
  public function setDeprecated($deprecated) {
    $this->deprecated = $deprecated;
    return $this;
  }

  /**
   * Get URI.
   *
   * @return string
   *   The URI string.
   */
  public function getUri() {
    return $this->uri;
  }

  /**
   * Set URI.
   *
   * @param string $uri
   *   The URI string.
   *
   * @return License
   *   The license object.
   */
  public function setUri($uri) {
    $this->uri = $uri;
    return $this;
  }

  /**
   * Get library name.
   *
   * @return string
   *   The library name string.
   */
  public function getLibraryName() {
    return $this->libraryName;
  }

  /**
   * Set library name.
   *
   * @param string $libraryName
   *   The library name string.
   *
   * @return License
   *   The license object.
   */
  public function setLibraryName($libraryName) {
    $this->libraryName = $libraryName;
    return $this;
  }

  /**
   * Get library version.
   *
   * @return string
   *   The library version string.
   */
  public function getLibraryVersion() {
    return $this->libraryVersion;
  }

  /**
   * Set library version.
   *
   * @param string $libraryVersion
   *   The library version string.
   *
   * @return License
   *   The license object.
   */
  public function setLibraryVersion($libraryVersion) {
    $this->libraryVersion = $libraryVersion;
    return $this;
  }

  /**
   * Gert library homepage.
   *
   * @return string
   *   The library homepage string.
   */
  public function getLibraryHomepage() {
    return $this->libraryHomepage;
  }

  /**
   * Set library homepage.
   *
   * @param string $libraryHomepage
   *   The library homepage string.
   *
   * @return License
   *   The license object.
   */
  public function setLibraryHomepage($libraryHomepage) {
    $this->libraryHomepage = $libraryHomepage;
    return $this;
  }

  /**
   * Get library description.
   *
   * @return string
   *   The library description string.
   */
  public function getLibraryDescription() {
    return $this->libraryDescription;
  }

  /**
   * Set library description.
   *
   * @param string $libraryDescription
   *   The library description string.
   *
   * @return License
   *   The license object.
   */
  public function setLibraryDescription($libraryDescription) {
    $this->libraryDescription = $libraryDescription;
    return $this;
  }

}
