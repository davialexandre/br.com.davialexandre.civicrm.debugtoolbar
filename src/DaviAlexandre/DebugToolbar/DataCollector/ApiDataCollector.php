<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;

use Civi\API\Event\PrepareEvent;
use Civi\API\Event\RespondEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ApiDataCollector implements DataCollectorInterface, EventSubscriberInterface {

  private $data = [];

  public function getName() {
    return 'api';
  }

  public function collect() {}

  public function getNumberOfApiCalls() {
    return count($this->data);
  }

  public function getTotalTime() {
    return array_sum(array_column($this->data, 'time'));
  }

  public function getAverageCallTime() {
    return $this->getTotalTime() / count($this->data);
  }

  public function getApiCalls() {
    return $this->data;
  }

  public static function getSubscribedEvents() {
    return [
      'civi.api.prepare' => 'onApiPrepare',
      'civi.api.respond' => 'onApiRespond',
    ];
  }

  public function onApiPrepare(PrepareEvent $event) {
    $apiRequest = $event->getApiRequest();
    $apiRequest['debugtoolbar_start_time'] = microtime(true);
    $event->setApiRequest($apiRequest);
  }

  public function onApiRespond(RespondEvent $event) {
    $apiRequest = $event->getApiRequest();

    $this->data[] = [
      'time' => round(microtime(true) - $apiRequest['debugtoolbar_start_time'],3)*1000,
      'entity' => $apiRequest['entity'],
      'action' => $apiRequest['action'],
      'params' => $apiRequest['params'],
      'response' => $event->getResponse(),
    ];
  }
}
