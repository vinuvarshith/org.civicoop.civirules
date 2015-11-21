<?php

class CRM_CivirulesConditions_Case_IsClient extends CRM_Civirules_Condition {

  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $caseRole = $triggerData->getEntityData('CaseRole');
    if (!empty($caseRole['is_client'])) {
      return true;
    }
    return false;
  }

  public function getExtraDataInputUrl($ruleConditionId) {
    return false;
  }

  /**
   * Returns an array with required entity names
   *
   * @return array
   * @access public
   */
  public function requiredEntities() {
    return array('Case');
  }

}