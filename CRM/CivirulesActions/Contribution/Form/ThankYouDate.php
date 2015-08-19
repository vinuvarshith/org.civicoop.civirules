<?php
/**
 * Class for CiviRules Contribution Thank You Date Form
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @license AGPL-3.0
 */

class CRM_CivirulesActions_Contribution_Form_ThankYouDate extends CRM_CivirulesActions_Form_Form {

  /**
   * Overridden parent method to build the form
   *
   * @access public
   */
  public function buildQuickForm() {
    $this->add('hidden', 'rule_action_id');
    $this->addDate('thank_you_date', ts('Thank You Date'), FALSE, array('formatType' => 'custom'));
    $this->addButtons(array(
      array('type' => 'next', 'name' => ts('Save'), 'isDefault' => TRUE,),
      array('type' => 'cancel', 'name' => ts('Cancel'))));
  }

  /**
   * Overridden parent method to set default values
   *
   * @return array $defaultValues
   * @access public
   */
  public function setDefaultValues() {
    $defaultValues = parent::setDefaultValues();
    $defaultValues['rule_action_id'] = $this->ruleActionId;
    if (!empty($this->ruleAction->action_params)) {
      $data = unserialize($this->ruleAction->action_params);
    }
    if (empty($data['thank_you_date'])) {
      list($defaultValues['thank_you_date']) = CRM_Utils_Date::setDateDefaults(date('Y-m-d'));
    } else {
      list($defaultValues['thank_you_date']) = CRM_Utils_Date::setDateDefaults($data['thank_you_date']);
    }
    return $defaultValues;
  }

  /**
   * Overridden parent method to process form data after submitting
   *
   * @access public
   */
  public function postProcess() {
    $data['thank_you_date'] = $this->_submitValues['thank_you_date'];
    $this->ruleAction->action_params = serialize($data);
    $this->ruleAction->save();
    parent::postProcess();
  }
}