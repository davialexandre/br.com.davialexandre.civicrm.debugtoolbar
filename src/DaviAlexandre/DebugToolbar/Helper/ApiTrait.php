<?php

namespace DaviAlexandre\DebugToolbar\Helper;


trait ApiTrait {

  private function apiGet($entity) {
    $response = civicrm_api3($entity, 'get');

    return empty($response['values']) ? [] : $response['values'];
  }

  private function apiGetFirst($entity) {
    $response = $this->apiGet($entity);

    return reset($response);
  }

}
