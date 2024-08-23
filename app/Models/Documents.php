<?php

namespace App\Models;

class Documents extends Model {

    protected $table = 'documents';

    protected $id = 'idDocument';


	private $idDocument ;					// nombre
	private $type;							// chaîne de caractères
	private $abrevation;					// chaîne de caractères
	private $lien;							// chaîne de caractères

    

    public function ecrire($data, $newContrat)
{
    $cheminCarteGrise = $data['carteGrise'];
    $cheminPermis = $data['permis'];

    $abrevationCarteGrise = 'CG';
    $abrevationPermis = 'PER';

    $typeCarteGrise = pathinfo($cheminCarteGrise, PATHINFO_EXTENSION);
    $typePermis = pathinfo($cheminPermis, PATHINFO_EXTENSION);

    $cheminCarteGrise = str_replace(' ', '-', $cheminCarteGrise);
    $cheminPermis = str_replace(' ', '-', $cheminPermis);

    $idCarteGrise = null;
    $idPermis = null;

    // Exécuter la première requête pour la carte grise
    $sqlCarteGrise = "INSERT INTO {$this->table} (type, abrevation, lien) VALUES (?, ?, ?)";
    $paramsCarteGrise = [$typeCarteGrise, $abrevationCarteGrise, $cheminCarteGrise];
    $resultsCG = $this->query($sqlCarteGrise, $paramsCarteGrise);
    if ($resultsCG) {
        // Récupérer l'ID de l'enregistrement inséré
        $idCarteGrise = $this->query("SELECT idDocument FROM {$this->table} ORDER BY idDocument DESC LIMIT 1");
    }

    // Exécuter la deuxième requête pour le permis
    $sqlPermis = "INSERT INTO {$this->table} (type, abrevation, lien) VALUES (?, ?, ?)";
    $paramsPermis = [$typePermis, $abrevationPermis, $cheminPermis];
    $resultsPER = $this->query($sqlPermis, $paramsPermis);
    if ($resultsPER) {
        // Récupérer l'ID de l'enregistrement inséré
        $idPermis = $this->query("SELECT idDocument FROM {$this->table} ORDER BY idDocument DESC LIMIT 1");
    }

    // Vérifier si les deux enregistrements ont été insérés avec succès

    if ($idCarteGrise && $idPermis) {
        // Insérer les associations dans la table document_has_contrat
        $sqlAssocCarteGrise = "INSERT INTO documents_has_contrat (idDocument, idContrat) VALUES (?, ?)";
        $paramsAssocCarteGrise = [$idCarteGrise, $newContrat];
        $this->query($sqlAssocCarteGrise, $paramsAssocCarteGrise);

        $sqlAssocPermis = "INSERT INTO documents_has_contrat (idDocument, idContrat) VALUES (?, ?)";
        $paramsAssocPermis = [$idPermis, $newContrat];
        $this->query($sqlAssocPermis, $paramsAssocPermis);

        return [
            'idCarteGrise' => $idCarteGrise,
            'idPermis' => $idPermis,
            'message' => "Dossiers enregistrés avec succès"
        ];
    } else {
        return [
            'idCarteGrise' => null,
            'idPermis' => null,
            'message' => "Erreur lors de l'enregistrement des dossiers"
        ];
    }
}
   
	

}