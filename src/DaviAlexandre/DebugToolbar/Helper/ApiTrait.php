<?php

namespace DaviAlexandre\DebugToolbar\Helper;


trait ApiTrait {

  private function apiGet($entity, $params = []) {
    $response = civicrm_api3($entity, 'get', $params);

    return empty($response['values']) ? [] : $response['values'];
  }

  private function apiGetFirst($entity, $params = []) {
    $response = $this->apiGet($entity, $params);

    return reset($response);
  }

}
