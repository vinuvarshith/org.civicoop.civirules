<?php

class CRM_Civirules_Utils_CustomDataFromPre {

  private static $customValues = array();

  public static function pre($op, $objectName, $objectId, $params) {
    if (isset($params['custom']) && is_array($params['custom'])) {
      foreach($params['custom'] as $fid => $custom_values) {
        foreach($custom_values as $id => $field) {
          $value = $field['value'];
          self::setCustomData($objectName, $fid, $value, $id);
        }
      }
    }
  }

  private static function setCustomData($objectName, $field_id, $value, $id) {
    self::$customValues[$field_id][$id] = $value;
  }

  public static function addCustomDataToTriggerData(CRM_Civirules_TriggerData_TriggerData $triggerData) {
    foreach(self::$customValues as $field_id => $values) {
      foreach($values as $id => $value) {
        $triggerData->setCustomFieldValue($field_id, $id, $value);
      }
    }
  }




}