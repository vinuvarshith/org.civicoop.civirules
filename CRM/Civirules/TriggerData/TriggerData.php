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
    if (!empty($this->contact_id)) {
      return $this->contact_id;
    }
    foreach($this->entity_data as $entity => $data) {
      if (!empty($data['contact_id'])) {
        return $data['contact_id'];
      }
    }
    return null;
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
    //only lookup entities by their lower case name. Entity is now case insensetive
    if (isset($this->entity_data[strtolower($entity)]) && is_array($this->entity_data[strtolower($entity)])) {
      return $this->entity_data[strtolower($entity)];
    //just for backwards compatibility also check case sensitive entity
    } elseif (isset($this->entity_data[$entity]) && is_array($this->entity_data[$entity])) {
      return $this->entity_data[$entity];
    } elseif (strtolower($entity) == strtolower('Contact') && $this->getContactId()) {
      $contactObject = new CRM_Contact_BAO_Contact();
      $contactObject->id = $this->getContactId();
      $contactData = array();
      if ($contactObject->find(true)) {
        CRM_Core_DAO::storeValues($contactObject, $contactData);
      }
      return $contactData;
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
      $this->entity_data[strtolower($entity)] = $data;
    }
    return $this;
  }



}