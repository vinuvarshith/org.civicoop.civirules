DROP TABLE IF EXISTS `civirule_rule_action`;
DROP TABLE IF EXISTS `civirule_rule_tag`;
DROP TABLE IF EXISTS `civirule_rule_condition`;
DROP TABLE IF EXISTS `civirule_rule_log`;
DROP TABLE IF EXISTS `civirule_rule`;
DROP TABLE IF EXISTS `civirule_action`;
DROP TABLE IF EXISTS `civirule_condition`;
DROP TABLE IF EXISTS `civirule_trigger`;
DELETE FROM civicrm_managed WHERE module = 'org.civicoop.civirules';