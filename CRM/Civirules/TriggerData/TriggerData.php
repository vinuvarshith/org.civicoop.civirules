<?php

/**
 * Trigger data
 * If you have custom triggers you can create a subclass of this class
 * and change where needed
 *
 */
abstract class CRM_Civirules_TriggerData_TriggerData {

  /**
   * Contains data for entities available in the trigger
   *
   * @var array
   */
  private $entity_data = array();

  protected $contact_id = 0;

  /**
   * @var CRM_Civirules_Trigger
   */
  protected $trigger;

  public function __construct() {

  }

  /**
   * Set the trigger
   *
   * @param CRM_Civirules_Trigger $trigger
   */
  public function setTrigger(CRM_Civirules_Trigger $trigger) {
    $this->trigger = $trigger;
  }

  /**
   * @return CRM_Civirules_Trigger
   */
  public function getTrigger() {
    return $this->trigger;
  }

  /**
   * Returns the ID of the contact used in the trigger
   *
   * @return int
   */
  public function getContactId() {
    if ($this->contact_id) {
      return $this->contact_id;
    }
    foreach($this->entity_data as $data) {
      if (!empty($data['contact_id'])) {
        return $data['contact_id'];
      }
    }
  }

  /**
   * Returns an array with data for an entity
   *
   * If entity is not available then an empty array is returned
   *
   * @param string $entity
   * @return array
   */
  public function getEntityData($entity) {
    if (isset($this->entity_data[$entity]) && is_array($this->entity_data[$entity])) {
      return $this->entity_data[$entity];
    }
    return array();
  }

  /**
   * Sets data for an entity
   *
   * @param string $entity
   * @param array $data
   * @return CRM_CiviRules_Engine_TriggerData
   */
  public function setEntityData($entity, $data) {
    if (is_array($data)) {
      $this->entity_data[$entity] = $data;
    }
    return $this;
  }



}