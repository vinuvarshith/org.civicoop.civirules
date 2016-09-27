<?php
/**
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 */
class CRM_CivirulesActions_Case_SetDateFieldOnCase extends CRM_Civirules_Action {

  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/case/setdatefield', 'rule_action_id='.$ruleActionId);
  }

  public function processAction(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $case = $triggerData->getEntityData('Case');
    $actionParameters = $this->getActionParameters();
    $isCustomField = true;
    $field = 'custom_505';

    $date = new DateTime();
    $params = array();
    if (!empty($actionParameters['date'])) {
      $delayClass = unserialize(($actionParameters['date']));
      if ($delayClass instanceof CRM_Civirules_Delay_Delay) {
        $date = $delayClass->delayTo($date, $triggerData);
      }
    }

    if ($isCustomField) {
      if ($date instanceof DateTime) {
        $params[$field] = $date->format('Ymd His');
        $params['entity_id'] = $case['id'];
        civicrm_api('CustomValue', 'create', $params);
      }
    } else {
      if ($date instanceof DateTime) {
        $params[$field] = $date->format('Ymd His');
        $params['id'] = $case['id'];
        civicrm_api('Case', 'create', $params);
      }
    }
  }

  /**
   * This function validates whether this action works with the selected trigger.
   *
   * This function could be overriden in child classes to provide additional validation
   * whether an action is possible in the current setup.
   *
   * @param CRM_Civirules_Trigger $trigger
   * @param CRM_Civirules_BAO_Rule $rule
   * @return bool
   */
  public function doesWorkWithTrigger(CRM_Civirules_Trigger $trigger, CRM_Civirules_BAO_Rule $rule) {
    $providedEntities = $trigger->getProvidedEntities();
    if (isset($providedEntities['Case'])) {
      return true;
    }
    return false;
  }

}