ALTER TABLE `sf_tagging` ADD UNIQUE INDEX `user_ind` (`tag_id`, `taggable_model`, `taggable_id`);
