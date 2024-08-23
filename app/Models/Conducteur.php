<?php

namespace App\Models;

class Conducteur extends Model
{

	protected $table = 'info_conducteur';
	protected $id = 'idInfo_conducteur';


	private $idInfo_conducteur;				// nombre
	private $Genre;							// chaîne de caractères //genre
	private $Nom;							// chaîne de caractères
	private $Prenom;						// chaîne de caractères
	private $dateNaissance;					// objet date, heure
	private $Email;						// chaîne de caractères
	private $Telephone;						// nombre
	private $numRue;						// nombre
	private $Adresse;						// chaîne de caractères
	private $CP;							// nombre
	private $Ville;							// chaîne de caractères
	private $Pays;							// chaîne de caractères
	private $numPermis;						// nombre // num permis
	private $datePermis;					// objet date, heure //date permis
	private $paysPermis;					 // chaîne de caractères // pays permis



	public function ecrire($data): array
	{
    $this->Nom = $data['nom'];
    $this->Prenom = $data['prenom'];
    $this->Email = $data['email'];
    $this->Genre = $data['genre'];
    $this->Telephone = $data['telephone'];
    $this->numRue = $data['numRue'];
    $this->Adresse = $data['adresse'];
    $this->CP = $data['codePostal'];
    $this->Ville = $data['ville'];
    $this->Pays = $data['pays'];
    $this->dateNaissance = $data['dateNaissance'];
    $this->numPermis = $data['numPermis'];
    $this->datePermis = $data['datePermis'];
    $this->paysPermis = $data['paysPermis'];

    // Construction de la requête SQL avec les noms des colonnes de la table
    $sql = "INSERT INTO {$this->table} 
            (Nom, Prenom, Email, Genre, Telephone, numRue, Adresse, CP, Ville, Pays, dateNaissance, numPermis, datePermis, paysPermis)
            VALUES 
            (:Nom, :Prenom, :Email, :Genre, :Telephone, :numRue, :Adresse, :CP, :Ville, :Pays, :dateNaissance, :numPermis, :datePermis, :paysPermis)";
    
    // Préparation des paramètres à lier à la requête
    $params = [
        ':Nom' => $this->Nom,
        ':Prenom' => $this->Prenom,
        ':Email' => $this->Email,
        ':Genre' => $this->Genre,
        ':Telephone' => $this->Telephone,
        ':numRue' => $this->numRue,
        ':Adresse' => $this->Adresse,
        ':CP' => $this->CP,
        ':Ville' => $this->Ville,
        ':Pays' => $this->Pays,
        ':dateNaissance' => $this->dateNaissance,
        ':numPermis' => $this->numPermis,
        ':datePermis' => $this->datePermis,
        ':paysPermis' => $this->paysPermis,
    ];
    
    // Utilisation de la méthode query pour exécuter la requête préparée
    $result = $this->query($sql, $params);

    $idConduct = $this->query("SELECT idInfo_conducteur FROM {$this->table} ORDER BY idInfo_conducteur DESC LIMIT 1");
    
    return ['isSucces' => true, $idConduct[0]['idInfo_conducteur']];
}

	
	
}