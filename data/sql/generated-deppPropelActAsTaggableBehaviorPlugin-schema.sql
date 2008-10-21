
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_tag
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_tag`;


CREATE TABLE `sf_tag`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`is_tmp` TINYINT default 1 NOT NULL,
	`is_triple` TINYINT,
	`triple_namespace` VARCHAR(100),
	`triple_key` VARCHAR(100),
	`triple_value` VARCHAR(255),
	PRIMARY KEY (`id`),
	KEY `name`(`name`),
	KEY `triple1`(`triple_namespace`),
	KEY `triple2`(`triple_key`),
	KEY `triple3`(`triple_value`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- sf_tagging
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_tagging`;


CREATE TABLE `sf_tagging`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`tag_id` INTEGER  NOT NULL,
	`taggable_model` VARCHAR(30),
	`taggable_id` INTEGER,
	`user_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `tag`(`tag_id`),
	KEY `taggable`(`taggable_model`, `taggable_id`),
	CONSTRAINT `sf_tagging_FK_1`
		FOREIGN KEY (`tag_id`)
		REFERENCES `sf_tag` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
