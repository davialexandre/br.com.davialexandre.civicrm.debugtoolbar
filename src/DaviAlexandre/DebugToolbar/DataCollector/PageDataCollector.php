<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;


use Civi\Core\Event\GenericHookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageDataCollector implements DataCollectorInterface, EventSubscriberInterface {

  private $data = [];
  private $renderStart;

  public function collect() {}

  public function getName() {
    return 'page';
  }

  public function getRenderTime() {
    return $this->data['render_time'];
  }

  public function getClass() {
    return $this->data['class'];
  }

  public function getType() {
    if($this->data['is_form']) {
      return 'form';
    }

    return 'page';
  }

  public static function getSubscribedEvents() {
    return [
      'hook_civicrm_pageRun' => 'onPageRun',
      'hook_civicrm_preProcess' => 'onPreProcess',
      'hook_civicrm_alterContent' => 'onAlterContent',
    ];
  }

  public function onPageRun(GenericHookEvent $event) {
    $this->data['is_form'] = false;
    $this->data['class'] = get_class($event->page);
    $this->renderStart = microtime(true);
  }

  public function onPreProcess(GenericHookEvent $event) {
    $this->data['is_form'] = true;
    $this->data['class'] = get_class($event->form);
    $this->renderStart = microtime(true);
  }

  public function onAlterContent(GenericHookEvent $event) {
    if(get_class($event->object) == $this->data['class']) {
      $this->data['render_time'] = round(microtime(true) - $this->renderStart,3)*1000;
    }
  }
}
