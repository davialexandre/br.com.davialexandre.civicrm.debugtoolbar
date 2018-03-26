<?php

namespace DaviAlexandre\DebugToolbar\Profile;

use DaviAlexandre\DebugToolbar\DataCollector\DataCollectorInterface;

class Profiler {

  private $collectors = [];
  private $profileIdentifier;
  private $enabled = true;
  private $storage;

  public function __construct(ProfileStorageInterface $storage) {
    $this->storage = $storage;
    $this->createProfileIdentifier();
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

    $this->storage->write($profile);
  }

  public function loadProfile($identifier) {
    try {
      return $this->storage->read($identifier);
    } catch(\Exception $e) {
      return null;
    }
  }

  private function createProfileIdentifier() {
    if (!$this->profileIdentifier) {
      $this->profileIdentifier = substr(hash('sha256', uniqid(mt_rand(), true)), 0, 6);
    }

    return $this->profileIdentifier;
  }

  public function getProfileIdentifier() {
    return $this->profileIdentifier;
  }

  public function __destruct() {
    $profile = $this->collect();
    if($profile) {
      $this->saveProfile($profile);
    }
  }
}
