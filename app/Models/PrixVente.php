<?php


namespace App\Models;

use Database\DBConnection;

class PrixVente extends Model
{

    protected $table = 'prix_vente';
    protected $id = 'idPrixVente';


    protected $idPrixVente;         // nombre
    protected $idFournisseur;             // nombre
    protected $assistance;                 // bool
    protected $dateCreation;              // objet date, heure
    protected $typeContrat;               // chaîne de caractères
    protected $duree;                     // nombre
    protected $prix;                      // décimal













    public function setAll($result = array())
    {

        if (count($result) > 0) {
            $this->idPrixVente = $result['idPrixVente'];
            $this->idFournisseur = $result['idFournisseur'];
            $this->assistance = $result['Assistance'];
            $this->dateCreation = $result['dateCreation'];
            $this->typeContrat = $result['typeContrat'];
            $this->duree = $result['Duree'];
            $this->prix = $result['Prix'];

            $OK = true;
        }
        return $OK;
    }


    public function __call($name, $args)
    {
        $retour = false;
        if (substr($name, 0, 3) == 'get' || substr($name, 0, 3) == 'set') {
            $nameVar = strtolower(substr($name, 3, 1)) . substr($name, 4);
            if (property_exists($this, $nameVar)) {
                if (substr($name, 0, 3) == 'get')
                    $retour = $this->$nameVar;
                else {
                    $this->$nameVar = empty($args) || !is_array($args) ? null : $args[0];
                    $retour = true;
                }
            }
        }
        return $retour;
    }

    function getPrix($std = false, $virg = true)
    {
        if (is_numeric($this->prix) && $std)
            return ($virg) ? number_format($this->prix, 2, ',', '') : number_format($this->prix, 2, '.', '');
        else
            return $this->prix;

    }


    public function lire()
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->id} = :id ORDER BY {$this->id} LIMIT 1";
        $result = $this->query($sql, [':id' => $this->idPrixVente], true); // Récupère un seul enregistrement correspondant
        $num = count($result);
        var_dump($num);

        if ($num == 1) {
            $this->idPrixVente = $result[0][$this->id];
            $this->idFournisseur = $result[0]['idFournisseur'];
            $this->assistance = lireBoolSQL($result[0]['Assistance'], true);
            $this->dateCreation = lireDateHeureSQL($result[0]['dateCreation']);
            $this->typeContrat = lireSQL($result[0]['typeContrat']);
            $this->duree = $result[0]['Duree'];
            $this->prix = $result[0]['Prix'];

            $OK = true;
        }
        return $OK;
    }

    public function ecrire()
    {

        global $dbh;

        $sql = "INSERT INTO " . self::$table . " (idFournisseur, Assistance, dateCreation, typeContrat, Duree, Prix)";
        $sql .= " VALUES ('" . $this->idFournisseur . "', " . ecritBoolSQL($this->assistance, true) . ", " . ecritDateHeureSQL($this->dateCreation) . ", " . strToSQL($this->typeContrat) . ", '" . $this->duree . "', '" . $this->prix . "');";
        $result = $dbh->exec($sql);

        if ($result)
            $this->id = $dbh->lastInsertId();

        return $result;
    }

    public function update()
    {

        global $dbh;

        $sql = "UPDATE " . self::$table . " SET";
        $sql .= ", idFournisseur = '" . $this->idFournisseur . "'";
        $sql .= ", Assistance = " . ecritBoolSQL($this->assistance, true);
        $sql .= ", dateCreation = " . ecritDateHeureSQL($this->dateCreation);
        $sql .= ", Duree = " . strToSQL($this->typeContrat);
        $sql .= ", duree = '" . $this->duree . "'";
        $sql .= ", Prix = '" . $this->prix . "'";
        $sql .= " WHERE " . self::$id . " = '" . $this->id . "' LIMIT 1;";
        $result = $dbh->exec($sql);

        return $result;
    }

    public function delete()
    {

        global $dbh;

        $sql = "DELETE FROM " . self::$table;
        $sql .= " WHERE " . self::$id . " = '" . $this->id . "' LIMIT 1;";
        $result = $dbh->exec($sql);

        return $result;
    }

}
