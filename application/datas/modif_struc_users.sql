ALTER TABLE `users` ADD `niveau` VARCHAR( 25 ) NOT NULL DEFAULT 'niveau0';
UPDATE `xsuite-dev`.`users` SET `niveau` = 'niveau1' WHERE `users`.`id_user` =107;
