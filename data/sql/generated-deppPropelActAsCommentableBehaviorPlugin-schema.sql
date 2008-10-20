
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- sf_comment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `sf_comment`;


CREATE TABLE `sf_comment`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`commentable_model` VARCHAR(30),
	`commentable_id` INTEGER,
	`namespace` VARCHAR(50),
	`title` VARCHAR(100),
	`text` TEXT,
	`author_id` INTEGER,
	`author_name` VARCHAR(50),
	`author_email` VARCHAR(100),
	`author_website` VARCHAR(255),
	`created_at` DATETIME,
	`is_public` TINYINT default 1 NOT NULL,
	PRIMARY KEY (`id`),
	KEY `comments_index`(`namespace`, `commentable_model`, `commentable_id`),
	KEY `object_index`(`commentable_model`, `commentable_id`),
	KEY `author_index`(`author_id`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
