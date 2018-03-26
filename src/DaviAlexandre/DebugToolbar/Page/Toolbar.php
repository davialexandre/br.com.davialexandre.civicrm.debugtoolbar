<?php

namespace DaviAlexandre\DebugToolbar\Page;

class Toolbar extends \CRM_Core_Page {

  public function run() {
    $id = \CRM_Utils_Request::retrieve('id', 'String');

    if (!$id) {
      \CRM_Utils_System::civiExit();
    }

    /** @var \DaviAlexandre\DebugToolbar\Profile\Profiler $profiler */
    $profiler = \Civi::container()->get('debug_toolbar.profiler');
    $profiler->disable();
    $profile = $profiler->loadProfile($id);

    if(!$profile) {
      \CRM_Utils_System::civiExit();
    }

    $this->assign('profile', $profile);
    $this->assign('templates', \Civi::container()->getParameter('debug_toolbar.templates'));

    parent::run();
  }

}
