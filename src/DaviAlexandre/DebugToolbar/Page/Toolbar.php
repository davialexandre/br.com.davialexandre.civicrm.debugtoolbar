<?php

namespace DaviAlexandre\DebugToolbar\Page;

use \CRM_DebugToolbar_ExtensionUtil as E;

class Toolbar extends \CRM_Core_Page {

  public function run() {
    $id = \CRM_Utils_Request::retrieve('id', 'String');

    if (!$id) {
      \CRM_Utils_System::civiExit();
    }

    $profiler = \Civi::container()->get('debug_toolbar.profiler');
    $profiler->disable();
    $profile = $profiler->loadProfile($id);

    \Civi::resources()->addStyleFile(E::LONG_NAME, 'css/toolbar.css');

    $this->assign('profile', $profile);
    $this->assign('templates', \Civi::container()->getParameter('debug_toolbar.templates'));

    parent::run();
  }

}
