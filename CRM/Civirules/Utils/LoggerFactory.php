<?php

class CRM_Civirules_Utils_LoggerFactory {

  private static $logger = null;

  private static $loggerHookInvoked = false;

  /**
   * @return \Psr\Log\LoggerInterface|NULL
   */
  public static function getLogger() {
    if (empty(self::$logger) && self::$loggerHookInvoked === false) {
      $hook = CRM_Civirules_Utils_HookInvoker::singleton();
      $hook->hook_civirules_getlogger(self::$logger);
      self::$loggerHookInvoked = true;
    }
    return self::$logger;
  }

  public static function logError($reason, $original_error, CRM_Civirules_EventData_EventData $eventData, $context=array()) {
    $logger = CRM_Civirules_Utils_LoggerFactory::getLogger();
    if (empty($logger)) {
      return;
    }
    $error = "Rule: '{rule_title}' with id {rule_id} failed for contact {contact_id} because of {reason}";
    $context['rule_id'] = $eventData->getEvent()->getRuleId();
    $context['rule_title'] = $eventData->getEvent()->getRuleTitle();
    $context['original_error'] = $original_error;
    $context['contact_id'] = $eventData->getContactId();
    $context['reason'] = $reason;
    $logger->error($error, $context);
  }

}