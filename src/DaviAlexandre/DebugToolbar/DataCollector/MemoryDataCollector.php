<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

class MemoryDataCollector implements DataCollectorInterface {

  private $data = [];

  public function __construct() {
    $this->data = array(
      'memory' => 0,
      'memory_limit' => ini_get('memory_limit'),
    );
  }

  public function collect() {
    $this->data['memory'] = memory_get_peak_usage(true) / 1024 / 1024;
  }

  public function getMemory() {
    return $this->data['memory'];
  }

  public function getMemoryLimit() {
    return $this->data['memory_limit'];
  }

  public function getName() {
    return 'memory';
  }
}
