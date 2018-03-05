<?php

namespace DaviAlexandre\DebugToolbar;

use DaviAlexandre\DebugToolbar\DataCollector\DataCollectorInterface;

class Profiler {

  private $collectors = [];
  private $profileIdentifier;
  private $paths;
  private $enabled = true;

  public function __construct(\CRM_Core_Resources $resources, \Civi\Core\Paths $paths) {
    $resources->addSetting([
      'debug_toolbar_profile_identifier' => $this->createProfileIdentifier()
    ]);

    $this->paths = $paths;
  }

  public function enable() {
    $this->enabled = true;
  }

  public function disable() {
    $this->enabled = false;
  }

  public function isDisabled() {
    return !$this->enabled;
  }

  public function addDataCollector(DataCollectorInterface $collector) {
    $this->collectors[] = $collector;
  }

  public function collect() {
    if($this->isDisabled()) {
      return;
    }

    $profile = new Profile($this->createProfileIdentifier());
    $profile->setTime(new \DateTimeImmutable());
    $profile->setUrl(\CRM_Utils_Array::value('REQUEST_URI', $_SERVER));
    $profile->setMethod(\CRM_Utils_Array::value('REQUEST_METHOD', $_SERVER));

    foreach ($this->collectors as $collector) {
      $collector->collect();
      $profile->addCollector($collector);
    }

    return $profile;
  }

  public function saveProfile(Profile $profile) {
    if($this->isDisabled()) {
      return;
    }

    $profilePath = $this->getProfilePath($profile->getIdentifier());
    file_put_contents($profilePath, serialize($profile));
  }

  public function loadProfile($identifier) {
    $profilePath = $this->getProfilePath($identifier);

    return unserialize(file_get_contents($profilePath));
  }

  private function getProfilePath($identifier) {
    return $this->paths->getPath('[civicrm.files]/debug_toolbar/profiles/'.$identifier);
  }

  private function createProfileIdentifier() {
    if (!$this->profileIdentifier) {
      $this->profileIdentifier = substr(hash('sha256', uniqid(mt_rand(), true)), 0, 6);
    }

    return $this->profileIdentifier;
  }

  public function __destruct() {
    $profile = $this->collect();
    if($profile) {
      $this->saveProfile($profile);
    }
  }
}
