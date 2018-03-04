<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

use Civi\Core\Paths;

class CiviCRMDataCollector implements DataCollectorInterface {

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
    return (bool)$this->data['settings']['environment'];
  }

  private function getSystemInfo() {
    return $this->apiGetFirst('System');
  }

  private function getCiviCRMData() {
    $systemInfo = $this->getSystemInfo();

    if(empty($systemInfo['civi'])) {
      return;
    }

    $settings = $this->getSettings();
    return [
      'version' => \CRM_Utils_Array::value('version', $systemInfo['civi']),
      'settings' => $settings,
      'extensions' => $this->getExtensions(),
      'paths' => $this->getPaths($settings)
    ];
  }

  private function getSettings() {
    return $this->apiGetFirst('Setting');
  }

  private function getExtensions() {
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

  private function getPaths($settings) {
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

  private function apiGet($entity) {
    $response = civicrm_api3($entity, 'get');

    return empty($response['values']) ? [] : $response['values'];
  }

  private function apiGetFirst($entity) {
    $response = $this->apiGet($entity);

    return reset($response);
  }

  public function __sleep() {
    return ['data'];
  }
}
