<?php

namespace DaviAlexandre\DebugToolbar\Page;

class Profile extends \CRM_Core_Page {

  public function run() {
    $id = \CRM_Utils_Request::retrieve('id', 'String');
    $panel = \CRM_Utils_Request::retrieve('panel', 'String');

    if (!$id) {
      \CRM_Utils_System::civiExit();
    }

    $profiler = \Civi::container()->get('debug_toolbar.profiler');
    $profiler->disable();

    $profile = $profiler->loadProfile($id);

    $this->assign('profile', $profile);
    $this->assign('selectedCollector', $panel);
    $this->assign('templates', \Civi::container()->getParameter('debug_toolbar.templates'));

    // We render the template like this to avoid having it decorated with the surrounding CMS
    // theme. This means the the Profile.tpl template needs to have the full HTML markup,
    // including the head and body tags. Also, any resource file will have to be included
    // manually in the template, and things added using CRM_Core_Resources will not be added
    // to the page
    echo parent::$_template->fetch($this->getTemplateFileName());
    \CRM_Utils_System::civiExit();
  }

}
