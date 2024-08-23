-- Supprimer les données des tables enfants
-- DELETE FROM Utilisateur_has_Contrat;
-- DELETE FROM Documents_has_Contrat;
-- DELETE FROM Contrat_has_Option;
-- DELETE FROM Prix_vente_option;
-- DELETE FROM Prix_achat_option;
-- DELETE FROM Paiement;

-- -- Supprimer les données des tables parentes
-- DELETE FROM Documents;
-- DELETE FROM Contrat;
-- DELETE FROM Info_garantie;
-- DELETE FROM Info_vehicule;
-- DELETE FROM Utilisateur;
-- DELETE FROM Version;
-- DELETE FROM Info_conducteur;
-- DELETE FROM Prix_vente;
-- DELETE FROM Prix_Achat;
-- DELETE FROM Pays;
-- DELETE FROM Fournisseur;



INSERT INTO `assu_camping`.`Utilisateur` (`nom`, `prenom`, `email`, `password`) VALUES
('Doe', 'John', 'john.doe@example.com', 'password123'),
('Smith', 'Jane', 'jane.smith@example.com', 'password456'),
('Brown', 'Charlie', 'charlie.brown@example.com', 'password789');

INSERT INTO `assu_camping`.`Info_garantie` (`frais`, `debut`, `duree`) VALUES
('100 EUR', '2024-01-01', 12),
('200 EUR', '2024-06-01', 24),
('150 EUR', '2024-03-01', 18);

INSERT INTO `assu_camping`.`Fournisseur` (`Fournisseurs`) VALUES
('Fournisseur A'),
('Fournisseur B'),
('Fournisseur C');

INSERT INTO `assu_camping`.`Prix_vente` (`assistance`, `dateCreation`, `typeContrat`, `duree`, `prix`, `idFournisseur`) VALUES
(1, '2024-05-01', 'Type A', 12, 300.00, 1),
(0, '2024-05-01', 'Type B', 24, 500.00, 2),
(1, '2024-05-01', 'Type C', 36, 700.00, 3);

INSERT INTO `assu_camping`.`Prix_vente` (`assistance`, `dateCreation`, `typeContrat`, `duree`, `prix`, `idFournisseur`) VALUES
(1, '2024-05-01', 'Type A', 12, 300.00, 1),
(0, '2024-05-01', 'Type B', 24, 500.00, 2),
(1, '2024-05-01', 'Type C', 36, 700.00, 3);

INSERT INTO `assu_camping`.`Prix_Achat` (`assistance`, `dateCreation`, `typeContrat`, `duree`, `prix`, `idFournisseur`) VALUES
(1, '2024-05-01', 'Type A', 12, 250.00, 1),
(0, '2024-05-01', 'Type B', 24, 450.00, 2),
(1, '2024-05-01', 'Type C', 36, 650.00, 3);

INSERT INTO `assu_camping`.`Pays` (`idPays`, `code`, `alpha2`, `alpha3`, `nom_en_gb`, `nom_fr_fr`) VALUES
(1, 840, 'US', 'USA', 'United States', 'États-Unis'),
(2, 250, 'FR', 'FRA', 'France', 'France'),
(3, 276, 'DE', 'DEU', 'Germany', 'Allemagne');

INSERT INTO `assu_camping`.`Info_conducteur` (`genre`, `nom`, `prenom`, `dateNaissance`, `email`, `telephone`, `numRue`, `adresse`, `cp`, `ville`, `numPermis`, `datePermis`, `paysPermis`, `idPays`) VALUES
('M', 'Doe', 'John', '1980-01-01', 'john.doe@example.com', 1234567890, 12, 'Main St', 12345, 'Paris', 123456789, '2000-01-01', 'France', 2),
('F', 'Smith', 'Jane', '1990-02-02', 'jane.smith@example.com', 2345678901, 34, 'Second St', 23456, 'Lyon', 234567890, '2010-02-02', 'France', 2),
('M', 'Brown', 'Charlie', '1975-03-03', 'charlie.brown@example.com', 3456789012, 56, 'Third St', 34567, 'Berlin', 345678901, '1995-03-03', 'Germany', 3);

INSERT INTO `assu_camping`.`Version` (`version`, `carrosserie`, `puissanceFisc`, `energie`) VALUES
('Version A', 'SUV', '10', 'Essence'),
('Version B', 'Sedan', '8', 'Diesel'),
('Version C', 'Hatchback', '5', 'Electric');

INSERT INTO `assu_camping`.`Info_vehicule` (`marque`, `modele`, `paysOrigine`, `poids`, `immatriculation`, `dateMEC`, `nombrePlace`, `numIdentif`, `idVersion`, `idPays`) VALUES
('Toyota', 'Corolla', 'Japan', 1500, 'ABC123', '2020-01-01', 5, 123456789, 1, 1),
('Ford', 'Focus', 'USA', 1400, 'XYZ789', '2019-05-05', 5, 234567890, 2, 1),
('Renault', 'Clio', 'France', 1300, 'LMN456', '2021-03-03', 5, 345678901, 3, 2);

INSERT INTO `assu_camping`.`Contrat` (`assistance`, `statut`, `typeContrat`, `dateCreation`, `prixTotal`, `idInfo_garantie`, `idPrixVente`, `idPrixAchat`, `idInfo_conducteur`, `idInfo_vehicule`, `idUtilisateur`) VALUES
(1, 'Validé', 'Type A', '2024-05-01 12:00:00', 300.00, 1, 1, 1, 1, 1, 1),
(0, 'En cours', 'Type B', '2024-05-01 12:00:00', 500.00, 2, 2, 2, 2, 2, 2),
(1, 'Annulé', 'Type C', '2024-05-01 12:00:00', 700.00, 3, 3, 3, 3, 3, 3);

INSERT INTO `assu_camping`.`Documents` (`type`, `abrevation`, `lien`) VALUES
('Contrat', 'CT', 'https://example.com/documents/contrat1.pdf'),
('Facture', 'FC', 'https://example.com/documents/facture1.pdf'),
('Attestation', 'AT', 'https://example.com/documents/attestation1.pdf');

INSERT INTO `assu_camping`.`Paiement` (`reglement`, `reçuTPE`, `jourReglement`, `idContrat`) VALUES
(1, '12345TPE', '2024-05-02', 1),
(0, '67890TPE', '2024-05-03', 2),
(1, '54321TPE', '2024-05-04', 3);

INSERT INTO `assu_camping`.`Prix_vente_option` (`assistance`, `dateCreation`, `typeContrat`, `duree`, `prix`, `idFournisseur`) VALUES
(1, '2024-05-01', 'Option A', 12, 100.00, 1),
(0, '2024-05-01', 'Option B', 24, 200.00, 2),
(1, '2024-05-01', 'Option C', 36, 300.00, 3);

INSERT INTO `assu_camping`.`Prix_achat_option` (`assistance`, `dateCreation`, `typeContrat`, `duree`, `prix`, `idFournisseur`) VALUES
(1, '2024-05-01', 'Option A', 12, 90.00, 1),
(0, '2024-05-01', 'Option B', 24, 180.00, 2),
(1, '2024-05-01', 'Option C', 36, 270.00, 3);

INSERT INTO `assu_camping`.`Documents_has_Contrat` (`idDocument`, `idContrat`) VALUES
(1, 1),
(2, 2),
(3, 3);

INSERT INTO `assu_camping`.`Contrat_has_Option` (`idContrat`, `idPrixVenteOption`, `idPrixAchatOption`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3);
