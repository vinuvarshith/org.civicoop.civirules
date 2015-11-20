<?php

class CRM_CivirulesPostTrigger_Case extends CRM_Civirules_Trigger_Post {

  /**
   * Returns an array of entities on which the trigger reacts
   *
   * @return CRM_Civirules_TriggerData_EntityDefinition
   */
  protected function reactOnEntity() {
    return new CRM_Civirules_TriggerData_EntityDefinition($this->objectName, $this->objectName, $this->getDaoClassName(), 'Case');
  }

  /**
   * Return the name of the DAO Class. If a dao class does not exist return an empty value
   *
   * @return string
   */
  protected function getDaoClassName() {
    return 'CRM_Case_DAO_Case';
  }

  /**
   * Trigger a rule for this trigger
   *
   * @param $op
   * @param $objectName
   * @param $objectId
   * @param $objectRef
   */
  public function triggerTrigger($op, $objectName, $objectId, $objectRef) {
    $triggerData = $this->getTriggerDataFromPost($op, $objectName, $objectId, $objectRef);

    //trigger for each client
    $clients = CRM_Case_BAO_Case::getCaseClients($objectId);
    foreach($clients as $client) {
      $roleData = array();
      $roleData['contact_id'] = $client;
      $roleData['is_client'] = true;

      $triggerData->setEntityData('CaseRole', $roleData);
      $triggerData->setEntityData('Relationship', null);

      CRM_Civirules_Engine::triggerRule($this, clone $triggerData);
    }

    //trigger for each case role
    $relatedContacts = CRM_Case_BAO_Case::getRelatedContacts($objectId);
    foreach($relatedContacts as $contact) {
      $roleData = array();
      $roleData['contact_id'] = $contact['contact_id'];
      $roleData['is_client'] = false;

      $triggerData->setEntityData('CaseRole', $roleData);

      $relationshipData = null;
      $relationship = new CRM_Contact_BAO_Relationship();
      $relationship->contact_id_b = $contact['contact_id'];
      $relationship->case_id = $objectId;
      if ($relationship->find(true)) {
        CRM_Core_DAO::storeValues($relationship, $relationshipData);
      }
      $triggerData->setEntityData('Relationship', null);

      CRM_Civirules_Engine::triggerRule($this, clone $triggerData);
    }
  }

  /**
   * Returns an array of additional entities provided in this trigger
   *
   * @return array of CRM_Civirules_TriggerData_EntityDefinition
   */
  protected function getAdditionalEntities() {
    $entities = parent::getAdditionalEntities();
    $entities[] = new CRM_Civirules_TriggerData_EntityDefinition('CaseRole', 'CaseRole', 'CRM_CivirulesPostTrigger_DataSpecification_CaseRole', 'CaseRole');
    $entities[] = new CRM_Civirules_TriggerData_EntityDefinition('Relationship', 'Relationship', 'CRM_Contact_DAO_Relationship' , 'Relationship');
    return $entities;
  }

}