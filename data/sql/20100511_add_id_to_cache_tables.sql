ALTER TABLE opp_politician_history_cache DROP PRIMARY KEY;
ALTER TABLE opp_act_history_cache DROP PRIMARY KEY; 
ALTER TABLE opp_tag_history_cache DROP PRIMARY KEY; 
ALTER TABLE opp_politician_history_cache ADD id INTEGER NOT NULL AUTO_INCREMENT KEY FIRST, ADD UNIQUE INDEX data_tipo_id_ramo (data, chi_tipo, chi_id, ramo);
ALTER TABLE opp_act_history_cache ADD id INTEGER NOT NULL AUTO_INCREMENT KEY FIRST, ADD UNIQUE INDEX data_tipo_id (data, chi_tipo, chi_id);
ALTER TABLE opp_tag_history_cache ADD id INTEGER NOT NULL AUTO_INCREMENT KEY FIRST, ADD UNIQUE INDEX data_tipo_id (data, chi_tipo, chi_id);
