SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

DROP TABLE IF EXISTS `Paiement`;
DROP TABLE IF EXISTS `Contrat_has_Option`;
DROP TABLE IF EXISTS `Utilisateur_has_Contrat`;
DROP TABLE IF EXISTS `Documents_has_Contrat`;
DROP TABLE IF EXISTS `Contrat`;
DROP TABLE IF EXISTS `Documents`;
DROP TABLE IF EXISTS `Info_conducteur`;
DROP TABLE IF EXISTS `Info_vehicule`;
DROP TABLE IF EXISTS `Info_garantie`; 
DROP TABLE IF EXISTS `Pays`;
DROP TABLE IF EXISTS `Version`;
DROP TABLE IF EXISTS `Utilisateur`;
DROP TABLE IF EXISTS `Prix_vente_option`;
DROP TABLE IF EXISTS `Prix_vente`;
DROP TABLE IF EXISTS `Prix_achat_option`;
DROP TABLE IF EXISTS `Prix_Achat`;
DROP TABLE IF EXISTS `Fournisseur`;

-- -----------------------------------------------------
-- Table `mydb`.`Utilisateur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Utilisateur` (
  `idUtilisateur` INT NOT NULL AUTO_INCREMENT,
  `Nom` VARCHAR(45) NULL,
  `Prenom` VARCHAR(45) NULL,
  `email` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  PRIMARY KEY (`idUtilisateur`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Info_garantie`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Info_garantie` (
  `idInfo_garantie` INT NOT NULL AUTO_INCREMENT,
  `Frais` VARCHAR(45) NOT NULL,
  `Debut` DATE NOT NULL,
  `Duree` INT NOT NULL,
  PRIMARY KEY (`idInfo_garantie`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Fournisseur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Fournisseur` (
  `idFournisseur` INT NOT NULL AUTO_INCREMENT,
  `Fournisseurs` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idFournisseur`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Prix_vente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Prix_vente` (
  `idPrixVente` INT NOT NULL AUTO_INCREMENT,
  `Assistance` TINYINT NOT NULL,
  `dateCreation` DATE NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  `Duree` INT NOT NULL,
  `Prix` DECIMAL(10,2) NOT NULL,
  `idFournisseur` INT NOT NULL,
  PRIMARY KEY (`idPrixVente`),
  INDEX `fk_Tarif_Fournisseur1_idx` (`idFournisseur` ASC) ,
  CONSTRAINT `fk_Tarif_Fournisseur1`
    FOREIGN KEY (`idFournisseur`)
    REFERENCES `mydb`.`Fournisseur` (`idFournisseur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Prix_Achat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Prix_Achat` (
  `idPrixAchat` INT NOT NULL AUTO_INCREMENT,
  `Assistance` TINYINT NOT NULL,
  `dateCreation` DATE NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  `Duree` INT NOT NULL,
  `Prix` DECIMAL(10,2) NOT NULL,
  `idFournisseur` INT NOT NULL,
  PRIMARY KEY (`idPrixAchat`),
  INDEX `fk_Tarif_Fournisseur1_idx` (`idFournisseur` ASC) ,
  CONSTRAINT `fk_Tarif_Fournisseur10`
    FOREIGN KEY (`idFournisseur`)
    REFERENCES `mydb`.`Fournisseur` (`idFournisseur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Pays`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Pays` (
  `idPays` INT NOT NULL AUTO_INCREMENT,
  `nomPays` VARCHAR(45) NOT NULL,
  `codePays` INT NOT NULL,
  PRIMARY KEY (`idPays`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Info_conducteur`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Info_conducteur` (
  `idInfo_conducteur` INT NOT NULL AUTO_INCREMENT,
  `Genre` VARCHAR(10) NOT NULL,
  `Nom` VARCHAR(45) NOT NULL,
  `Prenom` VARCHAR(45) NOT NULL,
  `numRue` INT NOT NULL,
  `Adresse` VARCHAR(45) NOT NULL,
  `CP` INT NOT NULL,
  `Ville` VARCHAR(45) NOT NULL,
  `dateNaissance` DATE NOT NULL,
  `datePermis` DATE NULL,
  `paysPermis` VARCHAR(45) NOT NULL,
  `numPermis` INT NOT NULL,
  `idPays` INT NOT NULL,
  PRIMARY KEY (`idInfo_conducteur`),
  INDEX `fk_Info_conducteur_Pays1_idx` (`idPays` ASC) ,
  CONSTRAINT `fk_Info_conducteur_Pays1`
    FOREIGN KEY (`idPays`)
    REFERENCES `mydb`.`Pays` (`idPays`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Version`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Version` (
  `idVersion` INT NOT NULL AUTO_INCREMENT,
  `Version` VARCHAR(45) NOT NULL,
  `Carroserie` VARCHAR(45) NOT NULL,
  `PuissanceFisc` VARCHAR(45) NOT NULL,
  `Energie` VARCHAR(12) NOT NULL,
  PRIMARY KEY (`idVersion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Info_vehicule`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Info_vehicule` (
  `idInfo_vehicule` INT NOT NULL AUTO_INCREMENT,
  `Marque` VARCHAR(45) NOT NULL,
  `Modele` VARCHAR(45) NOT NULL,
  `paysOrigine` VARCHAR(45) NOT NULL,
  `Poids` TINYINT NOT NULL,
  `Immatriculation` VARCHAR(45) NOT NULL,
  `dateMEC` DATE NOT NULL,
  `nombrePlace` INT NOT NULL,
  `numIdentif` INT NOT NULL,
  `idVersion` INT NOT NULL,
  `idPays` INT NOT NULL,
  PRIMARY KEY (`idInfo_vehicule`),
  INDEX `fk_Info_vehicule_Version1_idx` (`idVersion` ASC) ,
  INDEX `fk_Info_vehicule_Pays1_idx` (`idPays` ASC) ,
  CONSTRAINT `fk_Info_vehicule_Version1`
    FOREIGN KEY (`idVersion`)
    REFERENCES `mydb`.`Version` (`idVersion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Info_vehicule_Pays1`
    FOREIGN KEY (`idPays`)
    REFERENCES `mydb`.`Pays` (`idPays`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Contrat` (


  `idUtilisateur` INT NOT NULL,
  `idContrat` INT NOT NULL AUTO_INCREMENT,
  `idInfo_garantie` INT NOT NULL,
  `idPrixVente` INT NOT NULL,
  `Prix_Achat_idPrixAchat` INT NOT NULL,
  `idInfo_conducteur` INT NOT NULL,
  `idInfo_vehicule` INT NOT NULL,
  `Assistance` TINYINT NOT NULL,
  `Statut` VARCHAR(45) NOT NULL,
  `prixTotal` DECIMAL(10,2) NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idContrat`),
  INDEX `fk_Contrat_Utilisateur_idx` (`idUtilisateur` ASC) ,
  INDEX `fk_Contrat_Info_garantie1_idx` (`idInfo_garantie` ASC) ,
  INDEX `fk_Contrat_Prix_vente1_idx` (`idPrixVente` ASC) ,
  INDEX `fk_Contrat_Prix_Achat1_idx` (`Prix_Achat_idPrixAchat` ASC) ,
  INDEX `fk_Contrat_Info_conducteur1_idx` (`idInfo_conducteur` ASC) ,
  INDEX `fk_Contrat_Info_vehicule1_idx` (`idInfo_vehicule` ASC) ,
   CONSTRAINT `fk_Contrat_Utilisateur`
    FOREIGN KEY (`Utilisateur`)
    REFERENCES `mydb`.`Utilisateur` (`idUtilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_Info_garantie1`
    FOREIGN KEY (`idInfo_garantie`)
    REFERENCES `mydb`.`Info_garantie` (`idInfo_garantie`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_Prix_vente1`
    FOREIGN KEY (`idPrixVente`)
    REFERENCES `mydb`.`Prix_vente` (`idPrixVente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_Prix_Achat1`
    FOREIGN KEY (`Prix_Achat_idPrixAchat`)
    REFERENCES `mydb`.`Prix_Achat` (`idPrixAchat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_Info_conducteur1`
    FOREIGN KEY (`idInfo_conducteur`)
    REFERENCES `mydb`.`Info_conducteur` (`idInfo_conducteur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_Info_vehicule1`
    FOREIGN KEY (`idInfo_vehicule`)
    REFERENCES `mydb`.`Info_vehicule` (`idInfo_vehicule`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Documents`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Documents` (
  `idDocument` INT NOT NULL AUTO_INCREMENT,
  `Type` VARCHAR(45) NOT NULL,
  `Abrevation` VARCHAR(10) NOT NULL,
  `Lien` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idDocument`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Paiement`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Paiement` (
  `idPaiement` INT NOT NULL AUTO_INCREMENT,
  `Reglement` TINYINT NOT NULL,
  `reçuTPE` VARCHAR(45) NOT NULL,
  `jourReglement` DATE NOT NULL,
  `idContrat` INT NOT NULL,
  PRIMARY KEY (`idPaiement`),
  INDEX `fk_Paiement_Contrat1_idx` (`idContrat` ASC) ,
  CONSTRAINT `fk_Paiement_Contrat1`
    FOREIGN KEY (`idContrat`)
    REFERENCES `mydb`.`Contrat` (`idContrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Utilisateur_has_Contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Utilisateur_has_Contrat` (
  `idUtilisateur` INT NOT NULL,
  `idContrat` INT NOT NULL,
  PRIMARY KEY (`idUtilisateur`, `idContrat`),
  INDEX `fk_Utilisateur_has_Contrat_Contrat1_idx` (`idContrat` ASC) ,
  INDEX `fk_Utilisateur_has_Contrat_Utilisateur1_idx` (`idUtilisateur` ASC) ,
  CONSTRAINT `fk_Utilisateur_has_Contrat_Utilisateur1`
    FOREIGN KEY (`idUtilisateur`)
    REFERENCES `mydb`.`Utilisateur` (`idUtilisateur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Utilisateur_has_Contrat_Contrat1`
    FOREIGN KEY (`idContrat`)
    REFERENCES `mydb`.`Contrat` (`idContrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Prix_vente_option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Prix_vente_option` (
  `idPrixVenteOption` INT NOT NULL AUTO_INCREMENT,
  `Assistance` TINYINT NOT NULL,
  `dateCreation` DATE NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  `Duree` INT NOT NULL,
  `Prix` DECIMAL(10,2) NOT NULL,
  `idFournisseur` INT NOT NULL,
  PRIMARY KEY (`idPrixVenteOption`),
  INDEX `fk_Tarif_Fournisseur1_idx` (`idFournisseur` ASC) ,
  CONSTRAINT `fk_Tarif_Fournisseur11`
    FOREIGN KEY (`idFournisseur`)
    REFERENCES `mydb`.`Fournisseur` (`idFournisseur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Prix_achat_option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Prix_achat_option` (
  `idPrixAchatOption` INT NOT NULL AUTO_INCREMENT,
  `Assistance` TINYINT NOT NULL,
  `dateCreation` DATE NOT NULL,
  `typeContrat` VARCHAR(45) NOT NULL,
  `Duree` INT NOT NULL,
  `Prix` DECIMAL(10,2) NOT NULL,
  `idFournisseur` INT NOT NULL,
  PRIMARY KEY (`idPrixAchatOption`),
  INDEX `fk_Tarif_Fournisseur1_idx` (`idFournisseur` ASC) ,
  CONSTRAINT `fk_Tarif_Fournisseur110`
    FOREIGN KEY (`idFournisseur`)
    REFERENCES `mydb`.`Fournisseur` (`idFournisseur`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Documents_has_Contrat`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Documents_has_Contrat` (
  `idDocument` INT NOT NULL,
  `idContrat` INT NOT NULL,
  PRIMARY KEY (`idDocument`, `idContrat`),
  INDEX `fk_Documents_has_Contrat_Contrat1_idx` (`idContrat` ASC) ,
  INDEX `fk_Documents_has_Contrat_Documents1_idx` (`idDocument` ASC) ,
  CONSTRAINT `fk_Documents_has_Contrat_Documents1`
    FOREIGN KEY (`idDocument`)
    REFERENCES `mydb`.`Documents` (`idDocument`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Documents_has_Contrat_Contrat1`
    FOREIGN KEY (`idContrat`)
    REFERENCES `mydb`.`Contrat` (`idContrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Contrat_has_Option`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Contrat_has_Option` (
  `idContrat` INT NOT NULL,
  `idPrixVenteOption` INT NOT NULL,
  `idPrixAchatOption` INT NOT NULL,
  PRIMARY KEY (`idContrat`, `idPrixVenteOption`, `idPrixAchatOption`),
  INDEX `fk_Contrat_has_Prix_vente_option_Prix_vente_option1_idx` (`idPrixVenteOption` ASC) ,
  INDEX `fk_Contrat_has_Prix_vente_option_Contrat1_idx` (`idContrat` ASC) ,
  INDEX `fk_Contrat_has_Prix_vente_option_Prix_achat_option1_idx` (`idPrixAchatOption` ASC) ,
  CONSTRAINT `fk_Contrat_has_Prix_vente_option_Contrat1`
    FOREIGN KEY (`idContrat`)
    REFERENCES `mydb`.`Contrat` (`idContrat`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_has_Prix_vente_option_Prix_vente_option1`
    FOREIGN KEY (`idPrixVenteOption`)
    REFERENCES `mydb`.`Prix_vente_option` (`idPrixVenteOption`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contrat_has_Prix_vente_option_Prix_achat_option1`
    FOREIGN KEY (`idPrixAchatOption`)
    REFERENCES `mydb`.`Prix_achat_option` (`idPrixAchatOption`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
