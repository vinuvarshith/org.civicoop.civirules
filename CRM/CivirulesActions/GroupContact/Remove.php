<?php

/**
 * Class for CiviRules Group Contact remove action.
 *
 * Adds a user to a group
 *
 * @author Jaap Jansma (CiviCooP) <jaap.jansma@civicoop.org>
 * @license AGPL-3.0
 */

class CRM_CivirulesActions_GroupContact_Remove extends CRM_CivirulesActions_GroupContact_GroupContact {

  /**
   * Method to set the api action
   *
   * @return string
   * @access protected
   */
  protected function getApiAction() {
    return 'delete';
  }

  /**
   * Process the action
   *
   * @param CRM_Civirules_EventData_EventData $eventData
   * @access public
   */
  public function processAction(CRM_Civirules_EventData_EventData $eventData) {
    $entity = $this->getApiEntity();
    $action = $this->getApiAction();
    $contactId = $eventData->getContactId();

    $action_params = $this->getActionParameters();
    $group_ids = array();
    if (!empty($action_params['group_id'])) {
      $group_ids = array($action_params['group_id']);
    } elseif (!empty($action_params['group_ids']) && is_array($action_params['group_ids'])) {
      $group_ids = $action_params['group_ids'];
    }
    foreach($group_ids as $group_id) {
      if (CRM_CivirulesConditions_Utils_GroupContact::isContactInGroup($contactId, $group_id)) {
        $params = array();
        $params['group_id'] = $group_id;

        //alter parameters by subclass
        $params = $this->alterApiParameters($params, $eventData);

        //execute the action
        $this->executeApiAction($entity, $action, $params);
      }
    }
  }
}