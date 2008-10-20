
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_votings
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_votings`;


CREATE TABLE `sf_votings`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`votable_model` VARCHAR(50)  NOT NULL,
	`votable_id` INTEGER  NOT NULL,
	`user_id` INTEGER,
	`voting` INTEGER default 1 NOT NULL,
	PRIMARY KEY (`id`),
	KEY `votable_index`(`votable_model`, `votable_id`, `user_id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
