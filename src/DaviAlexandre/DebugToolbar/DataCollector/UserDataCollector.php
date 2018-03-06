<?php

namespace DaviAlexandre\DebugToolbar\DataCollector;


use DaviAlexandre\DebugToolbar\Helper\ApiTrait;

class UserDataCollector implements DataCollectorInterface {

  use ApiTrait;

  private $data = [];

  public function collect() {
    $session = \CRM_Core_Session::singleton();
    if($session->get('ufID')) {

      $this->data = $this->getUserData();

      if(!empty($this->data['contact_id'])) {
        $contactData = $this->getContactData($this->data['contact_id']);
        $this->data['contact_display_name'] = $contactData['display_name'];
      }

    } else {

      $this->data = [
        'id' => '',
        'name' => 'anonymous',
        'email' => '',
        'contact_id' => '',
      ];

    }
  }

  private function getUserData() {
    return $this->apiGetFirst('User', ['contact_id' => 'user_contact_id']);
  }

  private function getContactData($contactID) {
    return $this->apiGetFirst('Contact', ['id' => $contactID]);
  }

  public function getUsername() {
    return $this->data['name'];
  }

  public function getUserID() {
    return $this->data['id'];
  }

  public function getContactDisplayName() {
    return empty($this->data['contact_display_name']) ? '' : $this->data['contact_display_name'];
  }

  public function getContactID() {
    return $this->data['contact_id'];
  }

  public function getUserEmail() {
    return $this->data['email'];
  }

  public function getName() {
    return 'user';
  }
}
