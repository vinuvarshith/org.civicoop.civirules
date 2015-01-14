CREATE TABLE IF NOT EXISTS `civirule_rule_action` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `rule_id` INT UNSIGNED NULL,
  `action_id` INT UNSIGNED NULL,
  `value` VARCHAR(128) NULL,
  `comparison_id` INT UNSIGNED NULL,
  `extra_params` TEXT NULL,
  `civicrm_form_class` VARCHAR(128) NULL,
  `is_active` TINYINT NULL DEFAULT 1,
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  INDEX `rule_idx` (`rule_id` ASC),
  INDEX `fk_action_idx` (`action_id` ASC),
  INDEX `fk_comparison_idx` (`comparison_id` ASC),
  CONSTRAINT `fk_rule`
    FOREIGN KEY (`rule_id`)
    REFERENCES `civirule_rule` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_action`
    FOREIGN KEY (`action_id`)
    REFERENCES `civirule_action` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comparison`
    FOREIGN KEY (`comparison_id`)
    REFERENCES `civirule_comparison` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci