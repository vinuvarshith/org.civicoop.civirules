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
    $contribution = $eventData->getEntityData('Contribution');
    $actionParams = $this->getActionParameters();
    $params = array(
      'id' => $contribution['id'],
      'thankyou_date' => date('Ymd', strtotime($actionParams['thank_you_date']))
    );
    try {
      civicrm_api3('Contribution', 'Create', $params);
    } catch (CiviCRM_API3_Exception $ex) {}
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a action
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleActionId
   * @return bool|string
   * @access public
   */
  public function getExtraDataInputUrl($ruleActionId) {
    return CRM_Utils_System::url('civicrm/civirule/form/action/contribution/thankyoudate', 'rule_action_id='.$ruleActionId);
  }

  /**
   * Returns a user friendly text explaining the condition params
   * e.g. 'Older than 65'
   *
   * @return string
   * @access public
   */
  public function userFriendlyConditionParams() {
    $return = '';
    $params = $this->getActionParameters();
    if (!empty($params['thank_you_date'])) {
      $return = 'Thank You Date for Contribution will be set to : '.date('d M Y', strtotime($params['thank_you_date']));
    }
    return $return;
  }
}