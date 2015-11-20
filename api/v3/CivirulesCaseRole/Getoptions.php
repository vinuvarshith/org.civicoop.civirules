<?php

/**
 * CiviRuleRule.Get API
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_civirules_case_role_getoptions($params) {
  if (!empty($params['field']) && $params['field'] == 'is_client') {
    $data[] = array(
      'key' => '0',
      'value' => ts('No')
    );
    $data[] = array(
      'key' => '1',
      'value' => ts('Yes'),
    );
    return civicrm_api3_create_success($data, $params, 'CivirulesCaseRole', 'Getoptions');
  }
  return civicrm_api3_create_error('Non existings field');
}