ALTER TABLE civirule_rule DROP INDEX fk_rule_event_idx;
ALTER TABLE civirule_rule CHANGE event_id trigger_id INT UNSIGNED;
ALTER TABLE civirule_rule CHANGE event_params trigger_params TEXT;
ALTER TABLE civirule_rule ADD CONSTRAINT fk_rule_trigger
  FOREIGN KEY (trigger_id) REFERENCES civirule_trigger(id);
ALTER TABLE civirule_rule ADD INDEX fk_rule_trigger_idx (trigger_id);
