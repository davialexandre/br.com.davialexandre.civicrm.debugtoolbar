<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

use DaviAlexandre\DebugToolbar\Helper\ApiTrait;

class SystemDataCollector implements DataCollectorInterface {

  use ApiTrait;

  private $data = [];

  public function getName() {
    return 'system';
  }

  public function collect() {
    $this->data = $this->apiGetFirst('System');
  }

  public function getPHPVersion() {
    return $this->getSimpleVersionNumber($this->data['php']['version']);
  }

  public function getMySQLVersion() {
    return $this->getSimpleVersionNumber($this->data['mysql']['version']);
  }

  public function getWebserverSoftware() {
    return $this->data['http']['software'];
  }

  public function getOS() {
    return sprintf('%s %s',
      \CRM_Utils_Array::value('type', $this->data['os']),
      \CRM_Utils_Array::value('release', $this->data['os'])
    );
  }

  public function getPHPSapi() {
    return $this->data['php']['sapi'];
  }

  public function getPHPExtensions() {
    return $this->data['php']['extensions'];
  }

  public function getPHPConfiguration() {
    return $this->data['php']['ini'];
  }

  public function getMySQLVariables() {
    return $this->data['mysql']['vars'];
  }

  /**
   * Returns the X.Y.Z part of a version number like X.Y.Z-alpha-foo-bar3
   *
   * @param string $version
   * @return string|null
   */
  public function getSimpleVersionNumber($version) {
    $matches = [];
    if (preg_match('/\d+?\.\d+?\.\d+?/', $version, $matches)) {
      return $matches[0];
    }

    return null;
  }

}
