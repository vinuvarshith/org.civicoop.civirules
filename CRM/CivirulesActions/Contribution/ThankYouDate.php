<?php
/**
 * Class for CiviRules Set Thank You Date for Contribution Action
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @license AGPL-3.0
 */
class CRM_CivirulesActions_Contribution_ThankYouDate extends CRM_Civirules_Action {
  /**
   * Method processAction to execute the action
   *
   * @param CRM_Civirules_EventData_EventData $eventData
   * @access public
   *
   */
  public function processAction(CRM_Civirules_EventData_EventData $eventData) {
    CRM_Core_Error::debug('eventData', $eventData);
    exit();
    $contactId = $eventData->getContactId();
  }
  /**
   * Method to return the url for additional form processing for action
   * and return false if none is needed
   *
   * @param int $ruleActionId
   * @return bool
   * @access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return FALSE;
  }


}