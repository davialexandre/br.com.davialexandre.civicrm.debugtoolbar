<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

use Civi\Core\Paths;
use DaviAlexandre\DebugToolbar\Helper\ApiTrait;

class CiviCRMDataCollector implements DataCollectorInterface {

  use ApiTrait;

  private $data = [];
  private $paths;

  public function __construct(Paths $paths) {
    $this->paths = $paths;
  }

  public function getName() {
    return 'civicrm';
  }

  public function collect() {
    $this->data = $this->getCiviCRMData();
  }

  public function getVersion() {
    return $this->data['version'];
  }

  public function getNumberOfExtensions() {
    return count($this->data['extensions']);
  }

  public function getNumberOfInstalledExtensions() {
    return count(array_filter($this->data['extensions'], function($extension) {
      return $extension['status'] == 'installed';
    }));
  }

  public function getNumberOfEnabledComponents() {
    if(empty($this->data['settings']['enable_components'])) {
      return 0;
    }

    return count($this->data['settings']['enable_components']);
  }

  public function getRootDir() {
    return $this->data['paths']['root'];
  }

  public function getExtensionsDir() {
    return $this->data['paths']['extensions'];
  }

  public function getTemporaryFilesDir() {
    return $this->data['paths']['temporaryFiles'];
  }

  public function getCustomFilesDir() {
    return $this->data['paths']['customFiles'];
  }

  public function getImagesDir() {
    return $this->data['paths']['images'];
  }

  public function isDebugEnabled() {
    return (bool)$this->data['settings']['debug_enabled'];
  }

  public function isBacktraceEnabled() {
    return (bool)$this->data['settings']['backtrace'];
  }

  public function getEnvironment() {
    return $this->data['settings']['environment'];
  }

  public function getExtensions() {
    return $this->data['extensions'];
  }

  public function getSettings() {
    return $this->data['settings'];
  }

  private function getSystemInfo() {
    return $this->apiGetFirst('System');
  }

  private function getCiviCRMData() {
    $systemInfo = $this->getSystemInfo();

    if(empty($systemInfo['civi'])) {
      return;
    }

    $settings = $this->getSettingsData();
    return [
      'version' => \CRM_Utils_Array::value('version', $systemInfo['civi']),
      'settings' => $settings,
      'extensions' => $this->getExtensionsData(),
      'paths' => $this->getPathsData($settings)
    ];
  }

  private function getSettingsData() {
    return $this->apiGetFirst('Setting');
  }

  private function getExtensionsData() {
    $extensions = $this->apiGet('Extension');

    $extensionsData = [];
    foreach ($extensions as $extension) {
      $extensionsData[] = [
        'type' => \CRM_Utils_Array::value('type', $extension),
        'key' => \CRM_Utils_Array::value('key', $extension),
        'name' => \CRM_Utils_Array::value('name', $extension),
        'version' => \CRM_Utils_Array::value('version', $extension),
        'status' => \CRM_Utils_Array::value('status', $extension),
        'path' => \CRM_Utils_Array::value('path', $extension),
        'schemaVersion' => $this->getSchemaVersion($extension['key'])
      ];
    }

    return $extensionsData;
  }

  private function getPathsData($settings) {
    return [
      'root' => $this->paths->getPath('[civicrm.root]/.'),
      'extensions' => $this->paths->getPath($settings['extensionsDir']),
      'temporaryFiles' => $this->paths->getPath($settings['uploadDir']),
      'customFiles' => $this->paths->getPath($settings['customFileUploadDir']),
      'images' => $this->paths->getPath($settings['imageUploadDir'])
    ];
  }

  private function getSchemaVersion($key) {
    $revision = \CRM_Core_BAO_Extension::getSchemaVersion($key);
    if (!$revision) {
      $revision = $this->getCurrentRevisionDeprecated($key);
    }

    return $revision;
  }

  private function getCurrentRevisionDeprecated($key) {
    $key = $key . ':version';
    return \CRM_Core_BAO_Setting::getItem('Extension', $key);
  }

  public function __sleep() {
    return ['data'];
  }
}
