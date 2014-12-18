
-- ---
-- Globals
-- ---

-- SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
-- SET FOREIGN_KEY_CHECKS=0;

-- ---
-- Table 'validations_demande_xprices'
-- 
-- ---

DROP TABLE IF EXISTS `validations_demande_xprices`;
		
CREATE TABLE `validations_demande_xprices` (
  `id` INTEGER NOT NULL AUTO_INCREMENT,
  `validations_demande_xprices_id` INTEGER NULL DEFAULT NULL,
  `id_demande_xprice` INT(11) NOT NULL,
  `id_user` INT(11) NOT NULL,
  `nom_validation` VARCHAR(80) NOT NULL,
  `date_validation` DATETIME NULL DEFAULT NULL,
  `etat_validation` VARCHAR(15) NOT NULL,
  `commentaire` MEDIUMTEXT NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  Key (`validations_demande_xprices_id`),
  Key (`id_user`),
  Key (`id_demande_xprice`)
);

-- ---
-- Table Properties
-- ---

ALTER TABLE `validations_demande_xprices` ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- ---
-- Foreign Keys 
-- ---

ALTER TABLE `validations_demande_xprices` ADD FOREIGN KEY (validations_demande_xprices_id) REFERENCES `validations_demande_xprices` (`id`);
ALTER TABLE `validations_demande_xprices` ADD FOREIGN KEY (id_demande_xprice) REFERENCES `demande_xprices` (`id_demande_xprice`);
ALTER TABLE `validations_demande_xprices` ADD FOREIGN KEY (id_user) REFERENCES `users` (`id_user`);
