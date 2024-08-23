<?php

namespace App\Models;

class Vehicule extends Model
{

	protected $table = 'info_vehicule';
	protected $id = 'idInfo_vehicule';

	private $idInfo_vehicule;				// nombre
	private $idVersion;						// nombre
	private $Marque;						// chaîne de caractères
	private $Modele;						// chaîne de caractères
	private $paysOrigine;					// chaîne de caractères
	private $Poids;							// bool
	private $Immatriculation;				// chaîne de caractères
	private $dateMEC;						// objet date, heure
	private $nombrePlace;					// nombre
	private $numIdentif;					// objet date, heure


	public function ecrire($data): array
	{
		$this->idVersion = 1;
		$this->Marque = $data['marque'];
		$this->Modele = $data['modele'];
		$this->paysOrigine = $data['origVehi'];
		$this->Poids = $data['poids'];
		$this->Immatriculation = $data['immatriculation'];
		$this->dateMEC = $data['dateMEC'];
		$this->nombrePlace = $data['nombrePlace'];
		$this->numIdentif = $data['numIdentif'];

		// Construction de la requête SQL avec les noms des colonnes de la table
		$sql = "INSERT INTO {$this->table} 
            (idVersion, Marque, Modele, paysOrigine, Poids, Immatriculation, dateMEC, nombrePlace, numIdentif)
            VALUES 
            (:idVersion, :Marque, :Modele, :paysOrigine, :Poids, :Immatriculation, :dateMEC, :nombrePlace, :numIdentif)";

		// Préparation des paramètres à lier à la requête
		$params = [
			':idVersion' => $this->idVersion,
			':Marque' => $this->Marque,
			':Modele' => $this->Modele,
			':paysOrigine' => $this->paysOrigine,
			':Poids' => $this->Poids,
			':Immatriculation' => $this->Immatriculation,
			':dateMEC' => $this->dateMEC,
			':nombrePlace' => $this->nombrePlace,
			':numIdentif' => $this->numIdentif,
		];

		// Utilisation de la méthode query pour exécuter la requête préparée
		$result = $this->query($sql, $params);

		// Retour du résultat de l'opération
		$idVehi = $this->query("SELECT idInfo_vehicule FROM {$this->table} ORDER BY idInfo_vehicule DESC LIMIT 1");
    
		return ['isSucces' => true, $idVehi[0]['idInfo_vehicule']];
	}








}