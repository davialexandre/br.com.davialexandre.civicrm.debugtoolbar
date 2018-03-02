<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

class CiviCRMDataCollector implements DataCollectorInterface {

  private $data = [];

  public function collect() {
    $this->data['civicrm'] = $this->getCiviCRMData();

    return $this->data;
  }

  private function getSystemInfo() {
    $values = $this->apiGet('System');

    return reset($values);
  }

  private function getCiviCRMData() {
    $systemInfo = $this->getSystemInfo();

    if(empty($systemInfo['civi'])) {
      return;
    }

    return [
      'version' => \CRM_Utils_Array::value('version', $systemInfo['civi']),
      'settings' => $this->getSettings(),
      'extensions' => $this->getExtensions()
    ];
  }

  private function getSettings() {
    return $this->apiGet('Setting');
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
}