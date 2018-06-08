<?php

class CRM_CivirulesConditions_Case_CaseActivity extends CRM_Civirules_Condition {

  private $conditionParams = array();

  /**
   * Method to set the Rule Condition data
   *
   * @param array $ruleCondition
   * @access public
   */
  public function setRuleConditionData($ruleCondition) {
    parent::setRuleConditionData($ruleCondition);
    $this->conditionParams = array();
    if (!empty($this->ruleCondition['condition_params'])) {
      $this->conditionParams = unserialize($this->ruleCondition['condition_params']);
    }
  }

  /**
   * Method to determine if the condition is valid
   *
   * @param CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return bool
   */
  public function isConditionValid(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $isConditionValid = FALSE;
    $case = $triggerData->getEntityData('Case');
    $daysInactive = $this->conditionParams['days_inactive'];

    try {
      $lastActivity = civicrm_api3('Activity', 'get', array(
        'sequential' => 1,
        'return' => array("modified_date"),
        'case_id' => $case['case_id'],
        'options' => array('sort' => "modified_date desc", 'limit' => 1),
      ))['values'][0];
    }
    catch (Exception $e) {
      return $isConditionValid;
    }

    $lastActivityDate = DateTime::createFromFormat("Y-m-d H:i:s", $lastActivity['modified_date']);
    $today = new DateTime();
    $diff = $today->diff($lastActivityDate)->format("%a");

    if($diff >= $daysInactive) {
      $isConditionValid = TRUE;
    }

    return $isConditionValid;
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a condition
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleConditionId
   * @return bool|string
   * @access public
   * @abstract
   */
  public function getExtraDataInputUrl($ruleConditionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/condition/case/caseactivity', 'rule_condition_id='
      .$ruleConditionId);
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
