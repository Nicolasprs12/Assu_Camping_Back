<?php

namespace App\Models;

use DateTime;
use Exception;

class Contrat extends Model
{

	protected $table = 'contrat';

	protected $id = 'idContrat';

	public $idUtilisateur;						// nombre
	public $idContrat;						// nombre
	public $idInfo_Garantie;				// nombre
	public $idInfo_Conducteur;				// nombre
	public $idInfo_Vehicule;				// nombre
	public $idPrixVente;					// nombre
	public $idPrixAchat;					// nombre
	public $assistance;					// bool
	public $statut;						// chaîne de caractères
	public $prixTotal;						// nombre
	public $typeContrat;					// chaîne de caractères

	public $dateCreation;					// date


	public function lireConRecents(int $id)
	{
		// Construire la requête SQL pour récupérer les contrats par ID utilisateur
		$sql = "SELECT c.idContrat, c.Statut, c.prixTotal, c.typeContrat, c.dateCreation, iv.Immatriculation, iv.Marque
		FROM {$this->table} c
		JOIN info_vehicule iv ON c.idInfo_vehicule = iv.idInfo_vehicule
		WHERE c.idUtilisateur = ?    
		ORDER BY c.dateCreation DESC
        LIMIT 5";
		
		$results = $this->query($sql, [$id]);

		if ($results) {
			$contrats = [];
			foreach ($results as $result) {
				$contrats[] = [
					// 'idContrat' => $result['idContrat'],
					'Statut' => $result['Statut'],
					'prixTotal' => $result['prixTotal'],
					'typeContrat' => $result['typeContrat'],
					'dateCreation' => $result['dateCreation'],
					'Immatriculation' => $result['Immatriculation'],
					'Marque' => $result['Marque']
				];
			}
			return $contrats;
		}
		return [];
	}


	public function lire(int $id)
	{
		$sql = "SELECT c.*, iv.*, ig.*, ic.*
				FROM {$this->table} c
				JOIN info_vehicule iv ON c.idInfo_vehicule = iv.idInfo_vehicule
				JOIN info_conducteur ic ON c.idInfo_conducteur = ic.idInfo_conducteur
				JOIN info_garantie ig ON c.idInfo_garantie = ig.idInfo_garantie
				WHERE c.idUtilisateur = ?";
		// var_dump($sql);
		$results = $this->query($sql, [$id]);

		if ($results) {
			return $results;
		}
		return [];
	}

	public function ecrire($data, $infoPerso, $infoVehi, $infoGarantie, $idUser): array
	{

		// Préparation des données
		$this->idUtilisateur = $idUser;
		$this->typeContrat = $data['selectedTypeContrat'];
		$this->assistance = 0;
		$this->statut = 'Sauvegardé';
		$this->dateCreation = (new DateTime())->format('Y-m-d H:i:s');
		$this->prixTotal = $data['prix'];
		$this->idInfo_Vehicule = $infoVehi;
		$this->idInfo_Conducteur = $infoPerso;
		$this->idInfo_Garantie = $infoGarantie;
		$this->idPrixVente = 1;
		$this->idPrixAchat = 1;

		// Construction de la requête SQL
		$sql = "INSERT INTO {$this->table} 
            (idUtilisateur, typeContrat, assistance, statut, dateCreation, prixTotal, idInfo_Vehicule, idInfo_Conducteur, idInfo_Garantie, idPrixVente, idPrixAchat)
            VALUES 
            (:idUtilisateur, :typeContrat, :assistance, :statut, :dateCreation, :prixTotal, :idInfo_Vehicule, :idInfo_Conducteur, :idInfo_Garantie, :idPrixVente, :idPrixAchat)";

		// Préparation des paramètres
		$params = [
			':idUtilisateur' => $this->idUtilisateur,
			':typeContrat' => $this->typeContrat,
			':assistance' => $this->assistance,
			':statut' => $this->statut,
			':dateCreation' => $this->dateCreation,
			':prixTotal' => $this->prixTotal,
			':idInfo_Vehicule' => $this->idInfo_Vehicule,
			':idInfo_Conducteur' => $this->idInfo_Conducteur,
			':idInfo_Garantie' => $this->idInfo_Garantie,
			':idPrixVente' => $this->idPrixVente,
			':idPrixAchat' => $this->idPrixAchat,
		];

		// Exécution de la requête
		$result = $this->query($sql, $params);
		// Récupération du dernier ID inséré
		$idContratResult = $this->query("SELECT idContrat FROM {$this->table} ORDER BY idContrat DESC LIMIT 1");
		if ($idContratResult) {
			$idContrat = $idContratResult[0]['idContrat'];
			return ['isSucces' => true, 'idContrat' => $idContrat];
		}
		return ['isSucces' => false];

	}

	public function commande($idContrat)
	{
		$sql = "SELECT c.prixTotal, c.typeContrat,  iv.immatriculation, iv.marque, ig.debut, ig.heureDebut, ig.duree, ic.nom, ic.prenom
				FROM {$this->table} c
				JOIN info_vehicule iv ON c.idInfo_vehicule = iv.idInfo_vehicule
				JOIN info_conducteur ic ON c.idInfo_conducteur = ic.idInfo_conducteur
				JOIN info_garantie ig ON c.idInfo_garantie = ig.idInfo_garantie
				WHERE c.idContrat = ?";


		$results = $this->query($sql, [$idContrat]);

		if ($results) {
			return $results;
		}
		return [];

	}

	public function payer($idContrat)
	{
		$sql = "UPDATE contrat
            SET statut = 'En attente' 
            WHERE idContrat = ?";


		// Exécution de la requête avec un paramètre sécurisé
		$results = $this->query($sql, [$idContrat]);

		if (!$results) {
			return "Le contrat a été payé";
		} else {
			return "Erreur lors de la mise à jour du statut du contrat";
		}
	}

	public function validation($idContrat)
	{
		$sql = "UPDATE contrat
				SET statut = 'En cours' 
				WHERE idContrat = ?";

		$results = $this->query($sql, [$idContrat]);

		if ($results) {
			return "Le contrat a été validé";
		} else {
			return "Erreur lors de la mise à jour du statut du contrat";
		}

	}

	public function delete(int $idContrat)
	{
		$sql = "DELETE FROM {$this->table} WHERE idContrat = ?";
		$results = $this->query($sql, [$idContrat]);

		if ($results) {
			return ['isSuccess' => true, 'message' => 'Ce contrat a été effacé'];
		} else {
			return ['isSuccess' => false, 'message' => 'Erreur lors de la suppression du contrat'];
		}
	}



}











