<?php
/**
 *
 * @author Daniël van Vuuren (hollandopensource.nl)
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */

class CRM_CivirulesConditions_Address_IsUnique extends CRM_Civirules_Condition {

  public function getExtraDataInputUrl($ruleConditionId) {
    return FALSE;
  }

  /**
   * Method to check if the condition is valid, will check if the address
   * is unique
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return bool
   * @access public
   */
  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData)
  {
    $uniqueAddressFields = array("street_address", "city", "state_province_id", "postal_code", "country_id");
    $addressData = $triggerData->getEntityData('address');
    $address = civicrm_api3('Address', 'getsingle', array(
      'return' => $uniqueAddressFields,
      'id' => $addressData['id'],
    ));
    if (!$address['is_error']) {
      $addressCountParams = array();
      foreach ($uniqueAddressFields as $field) {
        $addressCountParams[$field] = $address[$field];
      }
      $addressCount = civicrm_api3('Address', 'getcount', $addressCountParams);
      if ($addressCount == 1) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Returns an array with required entity names
   *
   * @return array
   * @access public
   */
  public function requiredEntities() {
    return array(
      'Address',
    );
  }
}