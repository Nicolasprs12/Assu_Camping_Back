<?php

namespace App\Models;

class Fournisseur extends Model {

    protected $table = 'fournisseur';

    protected $id = 'idFournisseur';


	private $idFournisseur;					// nombre
	private $fournisseurs;					// chaîne de caractères


    public function setAll($result = array())
    {

        if (count($result) > 0) {
            $this->idFournisseur = $result['idFournisseur'];
            $this->fournisseurs = $result['Fournisseurs'];

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

    public function lire()
    {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->id} = :id ORDER BY {$this->id} LIMIT 1";
        $result = $this->query($sql, [':id' => $this->idFournisseur], true); // Récupère un seul enregistrement correspondant
        $num = count($result);
        var_dump($num);

        if ($num == 1) {
            $this->idFournisseur = $result[0][$this->id];
            $this->fournisseurs = $result[0]['Fournisseurs'];

            $OK = true;
        }
        return $OK;
    }

    public function ecrire()
    {

        global $dbh;

        $sql = "INSERT INTO " . self::$table . " (Fournisseurs)";
        $sql .= "VALUES ('" . $this->fournisseurs . "');";
        $result = $dbh->exec($sql);

        if ($result)
            $this->id = $dbh->lastInsertId();

        return $result;
    }

    public function update()
    {

        global $dbh;

        $sql = "UPDATE " . self::$table . " SET";
        $sql .= ", Fournisseurs = '" . $this->fournisseurs . "'";
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