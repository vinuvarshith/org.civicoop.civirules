<?php

abstract class CRM_Civirules_Trigger {

  protected $ruleId;

  protected $triggerId;

  protected $triggerParams;

  public function setRuleId($ruleId) {
    $this->ruleId = $ruleId;
  }

  public function setTriggerParams($triggerParams) {
    $this->triggerParams = $triggerParams;
  }

  public function getRuleId() {
    return $this->ruleId;
  }

  public function setTriggerId($triggerId) {
    $this->triggerId = $triggerId;
  }

  public function getTriggerId() {
    return $this->triggerId;
  }

  /**
   * Returns an array of entities on which the trigger reacts
   *
   * @return CRM_Civirules_TriggerData_EntityDefinition
   */
  abstract protected function reactOnEntity();


  public function getProvidedEntities() {
    $additionalEntities = $this->getAdditionalEntities();
    foreach($additionalEntities as $entity) {
      $entities[$entity->key] = $entity;
    }

    $entity = $this->reactOnEntity();
    $entities[$entity->key] = $entity;

    return $entities;
  }

  /**
   * Returns an array of additional entities provided in this trigger
   *
   * @return array of CRM_Civirules_TriggerData_EntityDefinition
   */
  protected function getAdditionalEntities() {
    return array();
  }

  /**
   * Returns a redirect url to extra data input from the user after adding a trigger
   *
   * Return false if you do not need extra data input
   *
   * @param int $ruleId
   * @return bool|string
   * @access public
   * @abstract
   */
  public function getExtraDataInputUrl($ruleId) {
    return false;
  }

  /**
   * Returns a description of this trigger
   *
   * @return string
   * @access public
   * @abstract
   */
  public function getTriggerDescription() {
    return '';
  }

}