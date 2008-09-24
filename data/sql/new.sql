SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- opp_policy
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_policy`;


CREATE TABLE `opp_policy`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`titolo` VARCHAR(255),
	`descrizione` TEXT,
	`provvisoria` INTEGER,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_policy_has_votazione
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_policy_has_votazione`;


CREATE TABLE `opp_policy_has_votazione`
(
	`policy_id` INTEGER  NOT NULL,
	`votazione_id` INTEGER  NOT NULL,
	`voto` VARCHAR(25),
	`strong` INTEGER,
	PRIMARY KEY (`policy_id`,`votazione_id`),
	KEY `opp_policy_has_votazione_policy_id_index`(`policy_id`),
	KEY `opp_policy_has_votazione_votazione_id_index`(`votazione_id`),
	CONSTRAINT `opp_policy_has_votazione_FK_1`
		FOREIGN KEY (`policy_id`)
		REFERENCES `opp_policy` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_policy_has_votazione_FK_2`
		FOREIGN KEY (`votazione_id`)
		REFERENCES `opp_votazione` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_votazione_has_atto
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_votazione_has_atto`;


CREATE TABLE `opp_votazione_has_atto`
(
	`votazione_id` INTEGER  NOT NULL,
	`atto_id` INTEGER  NOT NULL,
	PRIMARY KEY (`votazione_id`,`atto_id`),
	KEY `opp_votazione_has_atto_votazione_id_index`(`votazione_id`),
	KEY `opp_votazione_has_atto_atto_id_index`(`atto_id`),
	CONSTRAINT `opp_votazione_has_atto_FK_1`
		FOREIGN KEY (`votazione_id`)
		REFERENCES `opp_votazione` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_votazione_has_atto_FK_2`
		FOREIGN KEY (`atto_id`)
		REFERENCES `opp_atto` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

SET FOREIGN_KEY_CHECKS = 1;