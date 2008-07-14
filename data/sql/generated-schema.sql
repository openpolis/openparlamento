
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- opp_appoggio
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_appoggio`;


CREATE TABLE `opp_appoggio`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`carica_id` INTEGER  NOT NULL,
	`aka` VARCHAR(60),
	`tipologia` INTEGER,
	`legislatura` TINYINT,
	PRIMARY KEY (`id`,`carica_id`),
	KEY `opp_appoggio_carica_id_index`(`carica_id`),
	CONSTRAINT `opp_appoggio_FK_1`
		FOREIGN KEY (`carica_id`)
		REFERENCES `opp_carica` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_atto
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_atto`;


CREATE TABLE `opp_atto`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`parlamento_id` INTEGER,
	`tipo_atto_id` INTEGER  NOT NULL,
	`ramo` TEXT,
	`numfase` INTEGER,
	`legislatura` INTEGER,
	`data_pres` DATE,
	`data_agg` DATE,
	`titolo` TEXT,
	`iniziativa` INTEGER,
	`completo` INTEGER,
	`descrizione` TEXT,
	`seduta` INTEGER,
	`iter` VARCHAR(100),
	`data_iter` DATE,
	PRIMARY KEY (`id`,`tipo_atto_id`),
	KEY `opp_atto_tipo_atto_id_index`(`tipo_atto_id`),
	CONSTRAINT `opp_atto_FK_1`
		FOREIGN KEY (`tipo_atto_id`)
		REFERENCES `opp_tipo_atto` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_atto_has_teseo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_atto_has_teseo`;


CREATE TABLE `opp_atto_has_teseo`
(
	`atto_id` INTEGER  NOT NULL,
	`teseo_id` INTEGER  NOT NULL,
	PRIMARY KEY (`atto_id`,`teseo_id`),
	KEY `opp_atto_has_teseo_atto_id_index`(`atto_id`),
	KEY `opp_atto_has_teseo_teseo_id_index`(`teseo_id`),
	CONSTRAINT `opp_atto_has_teseo_FK_1`
		FOREIGN KEY (`atto_id`)
		REFERENCES `opp_atto` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_atto_has_teseo_FK_2`
		FOREIGN KEY (`teseo_id`)
		REFERENCES `opp_teseo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_carica
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_carica`;


CREATE TABLE `opp_carica`
(
	`id` INTEGER  NOT NULL,
	`politico_id` INTEGER  NOT NULL,
	`carica` VARCHAR(30),
	`data_inizio` DATE,
	`data_fine` DATE,
	`legislatura` TINYINT,
	`circoscrizione` VARCHAR(60),
	`presenze` INTEGER,
	`assenze` INTEGER,
	`missioni` INTEGER,
	`parliament_id` INTEGER,
	`pdl_1` INTEGER,
	`pdl_2` INTEGER,
	`mozione_1` INTEGER,
	`mozione_di_fiducia_1` INTEGER,
	`mozione_ex_art138_comma_2_1` INTEGER,
	`interpellanza_1` INTEGER,
	`interpellanza_urgente_1` INTEGER,
	`interrogazione_a_risposta_immediata_in_assemblea_1` INTEGER,
	`interrogazione_a_risposta_orale_1` INTEGER,
	`interrogazione_a_risposta_scritta_1` INTEGER,
	`interrogazione_a_risposta_immediata_in_commissione_1` INTEGER,
	`interrogazione_a_risposta_in_commissione_1` INTEGER,
	`risoluzione_in_assemblea_1` INTEGER,
	`risoluzione_in_commissione_1` INTEGER,
	`risoluzione_in_commissione_conclusiva_di_dibattito_1` INTEGER,
	`odg_in_assemblea_su_bilancio_interno_1` INTEGER,
	`odg_in_assemblea_su_mozioni_o_altri_atti_1` INTEGER,
	`odg_in_assemblea_su_pdl_1` INTEGER,
	`odg_in_assemblea_su_pdl_di_bilancio_1` INTEGER,
	`odg_in_commissione_1` INTEGER,
	`odg_su_pdl_di_bilancio_in_commissione_1` INTEGER,
	`indice` FLOAT,
	`scaglione` INTEGER,
	`posizione` INTEGER,
	`media` FLOAT,
	PRIMARY KEY (`id`,`politico_id`),
	KEY `opp_carica_id_index`(`id`),
	KEY `opp_carica_politico_id_index`(`politico_id`),
	CONSTRAINT `opp_carica_FK_1`
		FOREIGN KEY (`politico_id`)
		REFERENCES `opp_politico` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_carica_has_atto
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_carica_has_atto`;


CREATE TABLE `opp_carica_has_atto`
(
	`atto_id` INTEGER  NOT NULL,
	`carica_id` INTEGER  NOT NULL,
	`tipo` VARCHAR(255),
	`data` DATE,
	`url` TEXT,
	PRIMARY KEY (`atto_id`,`carica_id`),
	KEY `opp_carica_has_atto_atto_id_index`(`atto_id`),
	KEY `opp_carica_has_atto_carica_id_index`(`carica_id`),
	CONSTRAINT `opp_carica_has_atto_FK_1`
		FOREIGN KEY (`atto_id`)
		REFERENCES `opp_atto` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_carica_has_atto_FK_2`
		FOREIGN KEY (`carica_id`)
		REFERENCES `opp_carica` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_carica_has_gruppo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_carica_has_gruppo`;


CREATE TABLE `opp_carica_has_gruppo`
(
	`carica_id` INTEGER  NOT NULL,
	`gruppo_id` INTEGER  NOT NULL,
	`data_inizio` DATE,
	`data_fine` DATE,
	`ribelle` INTEGER,
	PRIMARY KEY (`carica_id`,`gruppo_id`),
	KEY `opp_carica_has_gruppo_carica_id_index`(`carica_id`),
	KEY `opp_carica_has_gruppo_gruppo_id_index`(`gruppo_id`),
	CONSTRAINT `opp_carica_has_gruppo_FK_1`
		FOREIGN KEY (`carica_id`)
		REFERENCES `opp_carica` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_carica_has_gruppo_FK_2`
		FOREIGN KEY (`gruppo_id`)
		REFERENCES `opp_gruppo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_gruppo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_gruppo`;


CREATE TABLE `opp_gruppo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`nome` VARCHAR(255),
	`acronimo` VARCHAR(80),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_legislatura_has_gruppo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_legislatura_has_gruppo`;


CREATE TABLE `opp_legislatura_has_gruppo`
(
	`legislatura` TINYINT  NOT NULL,
	`ramo` CHAR(1)  NOT NULL,
	`gruppo_id` INTEGER  NOT NULL,
	PRIMARY KEY (`legislatura`,`ramo`,`gruppo_id`),
	KEY `opp_legislatura_has_gruppo_legislatura_index`(`legislatura`),
	KEY `opp_legislatura_has_gruppo_ramo_index`(`ramo`),
	KEY `opp_legislatura_has_gruppo_gruppo_id_index`(`gruppo_id`),
	CONSTRAINT `opp_legislatura_has_gruppo_FK_1`
		FOREIGN KEY (`gruppo_id`)
		REFERENCES `opp_gruppo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_politico
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_politico`;


CREATE TABLE `opp_politico`
(
	`id` INTEGER  NOT NULL,
	`nome` VARCHAR(30),
	`cognome` VARCHAR(30),
	PRIMARY KEY (`id`),
	KEY `opp_politico_id_index`(`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_seduta
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_seduta`;


CREATE TABLE `opp_seduta`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`data` DATE,
	`numero` INTEGER  NOT NULL,
	`ramo` CHAR(1)  NOT NULL,
	`legislatura` TINYINT  NOT NULL,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_tipo_atto
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_tipo_atto`;


CREATE TABLE `opp_tipo_atto`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`denominazione` VARCHAR(60),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_teseo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_teseo`;


CREATE TABLE `opp_teseo`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`denominazione` TEXT,
	`ns_denominazione` TEXT,
	`teseott_id` INTEGER  NOT NULL,
	`tt` INTEGER,
	PRIMARY KEY (`id`,`teseott_id`),
	KEY `opp_teseo_teseott_id_index`(`teseott_id`),
	CONSTRAINT `opp_teseo_FK_1`
		FOREIGN KEY (`teseott_id`)
		REFERENCES `opp_teseott` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_teseo_has_teseott
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_teseo_has_teseott`;


CREATE TABLE `opp_teseo_has_teseott`
(
	`opp_teseo_id` INTEGER  NOT NULL,
	`opp_teseott_id` INTEGER  NOT NULL,
	PRIMARY KEY (`opp_teseo_id`,`opp_teseott_id`),
	KEY `opp_teseo_has_teseott_opp_teseo_id_index`(`opp_teseo_id`),
	KEY `opp_teseo_has_teseott_opp_teseott_id_index`(`opp_teseott_id`),
	CONSTRAINT `opp_teseo_has_teseott_FK_1`
		FOREIGN KEY (`opp_teseo_id`)
		REFERENCES `opp_teseo` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_teseo_has_teseott_FK_2`
		FOREIGN KEY (`opp_teseott_id`)
		REFERENCES `opp_teseott` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_teseott
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_teseott`;


CREATE TABLE `opp_teseott`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`denominazione` TEXT,
	`ns_denominazione` TEXT,
	`teseo_senato` INTEGER,
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_votazione
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_votazione`;


CREATE TABLE `opp_votazione`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`seduta_id` INTEGER  NOT NULL,
	`numero_votazione` TINYINT  NOT NULL,
	`titolo` TEXT,
	`presenti` INTEGER,
	`votanti` INTEGER,
	`maggioranza` INTEGER,
	`astenuti` INTEGER,
	`favorevoli` INTEGER,
	`contrari` INTEGER,
	`esito` VARCHAR(20),
	`tipologia` VARCHAR(20),
	`descrizione` TEXT,
	`url` VARCHAR(255),
	PRIMARY KEY (`id`,`seduta_id`),
	KEY `opp_votazione_seduta_id_index`(`seduta_id`),
	CONSTRAINT `opp_votazione_FK_1`
		FOREIGN KEY (`seduta_id`)
		REFERENCES `opp_seduta` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_votazione_has_carica
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_votazione_has_carica`;


CREATE TABLE `opp_votazione_has_carica`
(
	`votazione_id` INTEGER  NOT NULL,
	`carica_id` INTEGER  NOT NULL,
	`voto` VARCHAR(40),
	PRIMARY KEY (`votazione_id`,`carica_id`),
	KEY `opp_votazione_has_carica_votazione_id_index`(`votazione_id`),
	KEY `opp_votazione_has_carica_carica_id_index`(`carica_id`),
	CONSTRAINT `opp_votazione_has_carica_FK_1`
		FOREIGN KEY (`votazione_id`)
		REFERENCES `opp_votazione` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_votazione_has_carica_FK_2`
		FOREIGN KEY (`carica_id`)
		REFERENCES `opp_carica` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- opp_votazione_has_gruppo
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `opp_votazione_has_gruppo`;


CREATE TABLE `opp_votazione_has_gruppo`
(
	`votazione_id` INTEGER  NOT NULL,
	`gruppo_id` INTEGER  NOT NULL,
	`voto` VARCHAR(40),
	PRIMARY KEY (`votazione_id`,`gruppo_id`),
	KEY `opp_votazione_has_gruppo_votazione_id_index`(`votazione_id`),
	KEY `opp_votazione_has_gruppo_gruppo_id_index`(`gruppo_id`),
	CONSTRAINT `opp_votazione_has_gruppo_FK_1`
		FOREIGN KEY (`votazione_id`)
		REFERENCES `opp_votazione` (`id`)
		ON DELETE CASCADE,
	CONSTRAINT `opp_votazione_has_gruppo_FK_2`
		FOREIGN KEY (`gruppo_id`)
		REFERENCES `opp_gruppo` (`id`)
		ON DELETE CASCADE
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
