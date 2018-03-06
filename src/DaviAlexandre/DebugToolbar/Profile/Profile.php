<?php

namespace DaviAlexandre\DebugToolbar\Profile;


use DaviAlexandre\DebugToolbar\DataCollector\DataCollectorInterface;

class Profile {

  private $identifier;
  private $time;
  private $url;
  private $method;
  private $collectors = [];

  public function __construct($identifier) {
    $this->identifier = $identifier;
  }

  /**
   * @return mixed
   */
  public function getIdentifier() {
    return $this->identifier;
  }

  /**
   * @return \DateTimeImmutable
   */
  public function getTime() {
    return $this->time;
  }

  /**
   * @param \DateTimeImmutable $time
   */
  public function setTime(\DateTimeImmutable $time) {
    $this->time = $time;
  }

  /**
   * @return mixed
   */
  public function getUrl() {
    return $this->url;
  }

  /**
   * @param mixed $url
   */
  public function setUrl($url) {
    $this->url = $url;
  }

  /**
   * @return mixed
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * @param mixed $method
   */
  public function setMethod($method) {
    $this->method = $method;
  }

  public function addCollector(DataCollectorInterface $collector) {
    $this->collectors[$collector->getName()] = $collector;
  }

  public function getCollectors() {
    return $this->collectors;
  }
}
