DROP TABLE IF EXISTS `#__nycc_locations`;
CREATE TABLE `#__nycc_locations` (
  `id`     BIGINT(20)   NOT NULL AUTO_INCREMENT,
  `name`   VARCHAR(50)  NOT NULL,
  `addr1`  VARCHAR(100) NOT NULL DEFAULT '',
  `addr2`  VARCHAR(100) NOT NULL DEFAULT '',
  `city`   VARCHAR(50)  NOT NULL DEFAULT '',
  `state`  VARCHAR(2)   NOT NULL DEFAULT 'NY',
  `zip`    VARCHAR(10)  NOT NULL DEFAULT '',
  `active` TINYINT(4)   NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_rates`;
CREATE TABLE `#__nycc_rates` (
  `id`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `label`         VARCHAR(25)         NOT NULL,
  `modifier`      FLOAT(7, 2)         NOT NULL DEFAULT '0.00',
  `is_multiplier` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  `active`        TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_events`;
CREATE TABLE `#__nycc_events` (
  `id`                BIGINT(20) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `name`              VARCHAR(100)         NOT NULL,
  `main_location`     BIGINT(20) UNSIGNED  NOT NULL DEFAULT '0',
  `short_description` VARCHAR(250)         NOT NULL,
  `long_description`  TEXT                 NOT NULL,
  `schedule`          TEXT                 NOT NULL,
  `image_path`        VARCHAR(255)         NOT NULL DEFAULT '',
  `base_price`        FLOAT(7, 2) UNSIGNED NOT NULL DEFAULT '0.00',
  `active`            TINYINT(3) UNSIGNED  NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_venues`;
CREATE TABLE `#__nycc_venues` (
  `id`           BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id`     BIGINT(20) UNSIGNED NOT NULL,
  `display_name` VARCHAR(50)         NOT NULL DEFAULT '',
  `location_id`  BIGINT(20) UNSIGNED NOT NULL,
  `event_date`   BIGINT(20) UNSIGNED NOT NULL,
  `active`       TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_venue_rates`;
CREATE TABLE `#__nycc_venue_rates` (
  `id`       BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venue_id` BIGINT(20) UNSIGNED NOT NULL,
  `rate_id`  BIGINT(20) UNSIGNED NOT NULL,
  `active`   BIGINT(20) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_attendees`;
CREATE TABLE `#_nycc_attendees` (
  `id`          BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name`  VARCHAR(50)         NOT NULL,
  `last_name`   VARCHAR(50)         NOT NULL,
  `grade`       SMALLINT(6)         NULL     DEFAULT NULL,
  `school`      VARCHAR(50)         NULL     DEFAULT NULL,
  `uscf_id`     VARCHAR(20)         NULL     DEFAULT NULL,
  `comments`    TEXT                NULL,
  `user_id`     BIGINT(20)          NOT NULL DEFAULT '0',
  `created`     TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_edited` TIMESTAMP           NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE IF EXISTS `#__nycc_registrations`;
CREATE TABLE `#__nycc_registrations` (
  `id`            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`       BIGINT(20) UNSIGNED NOT NULL DEFAULT '0',
  `session_id`    VARCHAR(191)        NOT NULL,
  `venue_id`      BIGINT(20) UNSIGNED NOT NULL,
  `attendee_id`   BIGINT(20) UNSIGNED NOT NULL,
  `rate_id`       INT(10) UNSIGNED    NOT NULL DEFAULT '0',
  `rate_modifier` FLOAT(7, 2)         NOT NULL DEFAULT '0.00',
  `base_fee`      FLOAT(7, 2)         NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';

DROP TABLE `#__nycc_users`;
CREATE TABLE `#__nycc_users` (
  `id`         BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` VARCHAR(50)         NOT NULL,
  `last_name`  VARCHAR(50)         NOT NULL,
  `email`      VARCHAR(100)        NOT NULL,
  `phone`      VARCHAR(20)         NOT NULL DEFAULT '',
  `address1`   VARCHAR(100)        NOT NULL DEFAULT '',
  `address2`   VARCHAR(100)        NOT NULL DEFAULT '',
  `city`       VARCHAR(50)         NOT NULL DEFAULT '',
  `state`      VARCHAR(10)         NOT NULL DEFAULT '',
  `zip`        VARCHAR(15)         NOT NULL DEFAULT '',
  `joomla_id`  INT(11)             NOT NULL DEFAULT '0',
  `auth_token` VARCHAR(15)         NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
)
  ENGINE = MyISAM
  COLLATE = 'utf8mb4_general_ci';
