
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_ratings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_ratings`;


CREATE TABLE `sf_ratings`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ratable_model` VARCHAR(50)  NOT NULL,
	`ratable_id` INTEGER  NOT NULL,
	`user_id` INTEGER,
	`rating` INTEGER default 1 NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ratable_index`(`ratable_model`, `ratable_id`, `user_id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
