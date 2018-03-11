<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DatabaseDataCollector implements DataCollectorInterface, EventSubscriberInterface {

  private $data;
  private $queryStack;

  public function collect() {}

  public function getName() {
    return 'database';
  }

  public static function getSubscribedEvents() {
      return [
        'hook_civicrm_config' => 'onConfig'
      ];
  }

  public function onConfig(GenericHookEvent $event) {
    global $_DB_DATAOBJECT;

    $_DB_DATAOBJECT['CONFIG']['debug'] = function($class, $message, $logtype, $level) {
      $this->handleDatabaseDebugMessage($class, $message, $logtype);
    };
  }

  public function getNumberOfQueries() {
    return count($this->data['queries']);
  }

  public function getTotalTime() {
    return array_sum(array_column($this->data['queries'], 'time'));
  }

  public function getAverageQueryTime() {
    return $this->getTotalTime() / $this->getNumberOfQueries();
  }

  public function getQueries() {
    return $this->data['queries'];
  }

  private function handleDatabaseDebugMessage($class, $message, $logtype) {
    if ($logtype == 'QUERY') {
      $this->queryStack[$class][] = $message;
    }

    if ($logtype == 'query') {
      $query = array_pop($this->queryStack[$class]);
      $result = $this->parseResult($message);
      $this->data['queries'][] = [
        'class' => $class,
        'query' => $query,
        'time' => $result['time'],
        'rows' => $result['rows'],
        'columns' => $result['columns'],
      ];
    }
  }

  private function parseResult($result) {
    $parsedResult = [
      'time' => null,
      'rows' => null,
      'columns' => null
    ];

    $matches = [];
    if(preg_match('/ QUERY DONE IN ([\.\d]+?)  seconds\./', $result, $matches)) {
      $parsedResult['time'] = ((float)$matches[1]) * 1000;
    }

    $matches = [];
    if(preg_match('/ Result is (\d+?) rows by (\d+?) columns\./', $result,$matches)) {
      $parsedResult['rows'] = $matches[1];
      $parsedResult['columns'] = $matches[2];
    }

    return $parsedResult;
  }
}
