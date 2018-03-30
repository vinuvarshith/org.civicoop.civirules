<?php

return array (
  0 =>
    array (
      'name' => 'Civirules:Trigger.HouseholdCustomDataChanged',
      'entity' => 'CiviRuleTrigger',
      'params' =>
        array (
          'version' => 3,
          'name' => 'changed_household_custom_data',
          'label' => 'Custom data on Household changed',
          'cron' => 0,
          'class_name' => 'CRM_CivirulesPostTrigger_HouseholdCustomDataChanged',
          'is_active' => 1
        ),
    ),
);
