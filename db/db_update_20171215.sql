ALTER TABLE `categories`
ADD COLUMN `parentid`  smallint(5) NULL DEFAULT NULL AFTER `id`;

ALTER TABLE `materials`
ADD COLUMN `parentid`  smallint(5) NULL DEFAULT NULL AFTER `id`;

CREATE TABLE `config` (
  `key` text NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`key`(100))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;