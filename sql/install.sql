CREATE TABLE IF NOT EXISTS `civicrm_civialerts` (
  `id` INT(200) AUTO_INCREMENT,
  `alert_heading` LONGTEXT,
  `alert_body` LONGTEXT,
  `alert_url` LONGTEXT,
  `alert_user` VARCHAR(100),
  `alert_repeat` VARCHAR(300),
  `join_date` DATETIME,
  PRIMARY KEY (`id`)
);