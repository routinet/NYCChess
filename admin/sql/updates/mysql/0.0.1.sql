DROP TABLE IF EXISTS `#__nycc_locations`;

CREATE TABLE `#__nycc_locations` (
  `id`        INT(11)     NOT NULL AUTO_INCREMENT,
  `name`      VARCHAR(50) NOT NULL,
  `addr1`     VARCHAR(100) NOT NULL DEFAULT '',
  `addr2`     VARCHAR(100) NOT NULL DEFAULT '',
  `city`      VARCHAR(50) NOT NULL DEFAULT '',
  `state`     VARCHAR(2) NOT NULL DEFAULT 'NY',
  `zip`       VARCHAR(10) NOT NULL DEFAULT '',
  `published` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id`)
)
  ENGINE =MyISAM
  AUTO_INCREMENT =0
  DEFAULT CHARSET =utf8;
