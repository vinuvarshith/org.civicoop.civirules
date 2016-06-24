<?php

class CRM_Civirules_Delay_DayOfMonthBasedOnContribution extends CRM_Civirules_Delay_Delay {
  
  protected $day_of_month;

  /**
   * Returns the DateTime to which an action is delayed to
   *
   * @param DateTime $date
   * @param CRM_Civirules_TriggerData_TriggerData
   * @return DateTime
   */
  public function delayTo(DateTime $date, CRM_Civirules_TriggerData_TriggerData $triggerData) {
    $contribution = $triggerData->getEntityData('Contribution');
    if ($contribution) {
      $recive_date = $contribution['receive_date'];
      $newDate = new DateTime($recive_date);
      $newDate->modify('first day of this month');
      $modify_days = $this->day_of_month - 1;
      if ($modify_days < 0) {
        $modify_days = 0;
      }
      $newDate->modify('+'.$modify_days.' days');
      return $newDate;
    }
    return $date;
  }

  public function getDescription() {
    return ts('Delay by the xth day of the month of the contribution');
  }

  public function getDelayExplanation() {
    return ts('Delay by the %1 day of the month of the contribution', array(1 => $this->day_of_month));
  }

  public function addElements(CRM_Core_Form &$form) {
    $form->add('text', 'day_of_month', ts('Day of month (1-31)'));
  }

  public function validate($values, &$errors) {
    if (empty($values['day_of_month']) || !is_numeric($values['day_of_month']) || $values['day_of_month'] < 0 || $values['day_of_month'] > 31) {
      $errors['day_of_month'] = ts('You need to provide a day of the month (between 1 and 31)');
    }

    $rule = new CRM_Civirules_BAO_Rule();
    $rule->id = $values['rule_id'];
    $rule->find(TRUE);
    $trigger = new CRM_Civirules_BAO_Trigger();
    $trigger->id = $rule->trigger_id;
    $trigger->find(TRUE);

    $triggerObject = CRM_Civirules_BAO_Trigger::getPostTriggerObjectByClassName($trigger->class_name, TRUE);
    $triggerObject->setTriggerId($trigger->id);

    $availableEntities = $triggerObject->getProvidedEntities();
    if (!isset($availableEntities['Contribution'])) {
      $errors['delay_select'] = ts('This delay is not available with trigger %1', array(1 => $trigger->label));
    }
  }

  public function setValues($values) {
    $this->day_of_month = $values['day_of_month'];
  }

  public function getValues() {
    $values = array();
    $values['day_of_month'] = $this->day_of_month;
    return $values;
  }
  
}