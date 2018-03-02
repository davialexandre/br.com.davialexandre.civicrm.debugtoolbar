<?php

namespace DaviAlexandre\DebugToolbar;

use DaviAlexandre\DebugToolbar\DataCollector\DataCollectorInterface;

class Profiler {

  private $collectors = [];

  public function addDataCollector(DataCollectorInterface $collector) {
    $this->collectors[] = $collector;
  }

  public function collect() {
    foreach ($this->collectors as $collector) {
      $collector->collect();
    }
  }
}
