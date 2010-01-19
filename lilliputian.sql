CREATE TABLE `lilliputian` (
`key` VARCHAR( 255 ) NOT NULL ,
`url` TEXT NOT NULL ,
`hits` INT( 11 ) UNSIGNED NOT NULL DEFAULT '0',
`created` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY ( `key` )
) ENGINE = InnoDB CHARACTER SET utf8 COLLATE utf8_general_ci;