<?php

class CRM_CivirulesConditions_FieldValueComparison extends CRM_CivirulesConditions_Generic_ValueComparison {

  /**
   * Returns the value of the field for the condition
   * For example: I want to check if age > 50, this function would return the 50
   *
   * @param object CRM_Civirules_TriggerData_TriggerData $triggerData
   * @return
   * @access protected
   * @abstract
   */
  protected function getFieldValue(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $entity = $this->conditionParams['entity'];
    $field = $this->conditionParams['field'];

    $data = $triggerData->getEntityData($entity);
    if (isset($data[$field])) {
      return $this->normalizeValue($data[$field]);
    }

    if (strpos($field, 'custom_')===0) {
      try {
        $params['entityID'] = $data['id'];
        $params[$field] = 1;
        $values = CRM_Core_BAO_CustomValueTable::getValues($params);
        if (!empty($values[$field])) {
          return $this->normalizeValue($values[$field]);
        }
      } catch (Exception $e) {
        //do nothing
      }
    }

    return null;
  }

  /**
   * Returns the value for the data comparison
   *
   * @return mixed
   * @access protected
   */
  protected function getComparisonValue() {
    $value = parent::getComparisonValue();
    if (!empty($value)) {
      return $this->normalizeValue($value);
    } else {
      return null;
    }
  }

  protected function normalizeValue($value) {
    if ($value === null) {
      return null;
    }

    //@todo normalize value based on the field
    return $value;
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a condition
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleConditionId
   * @return bool|string
   * @access public
   */
  public function getExtraDataInputUrl($ruleConditionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/condition/fieldvaluecomparison/', 'rule_condition_id='.$ruleConditionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $value = $this->getComparisonValue();
    if (is_array($value)) {
      $value = implode(", ", $value);
    }
    return htmlentities($this->conditionParams['entity'].'.'.$this->conditionParams['field'].' '.($this->getOperator())).' '.htmlentities($value);
  }

}