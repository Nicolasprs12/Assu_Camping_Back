<?php

namespace App\Models;

class Garantie extends Model {

    protected $table = 'info_garantie';

    protected $id = 'idInfo_garantie';


	private $idInfo_garantie;				// nombre
	private $Frais;							// chaîne de caractères
	private $Debut;							// date
	private $Duree;							// nombre
	private $heureDebut;							// nombre

    public function ecrire($data): array
	{
    $this->Frais = 10;
    $this->Duree = $data['selectedDuree'];
    $this->Debut = $data['dateDebut'];
    $this->heureDebut = $data['heureDebut'];


    // Construction de la requête SQL avec les noms des colonnes de la table
    $sql = "INSERT INTO {$this->table} 
            (Frais, Duree, Debut, heureDebut)
            VALUES 
            (:Frais, :Duree, :Debut, :heureDebut)";
    
    // Préparation des paramètres à lier à la requête
    $params = [
        ':Frais' => $this->Frais,
        ':Duree' => $this->Duree,
        ':Debut' => $this->Debut,
        ':heureDebut' => $this->heureDebut,

    ];
    
    // Utilisation de la méthode query pour exécuter la requête préparée
    $result = $this->query($sql, $params);
    
    // Retour du résultat de l'opération
    $idGarantie = $this->query("SELECT idInfo_garantie FROM {$this->table} ORDER BY idInfo_garantie DESC LIMIT 1");
    
    return ['isSucces' => true, $idGarantie[0]['idInfo_garantie']];
}
}