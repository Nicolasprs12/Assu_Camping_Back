<?php

namespace App\Models;

class Paiement extends Model {

    protected $table = 'garantie';

    protected $id = 'idPaiement';

	private $idPaiement ;					// nombre
	private $idContrat ;					// nombre
	private $reglement;						// bool
	private $reçuTPE;						// chaîne de caractères
	private $jourReglement;					// objet date, heure

	public function setAll($result = array())
    {

        if (count($result) > 0) {
            $this->idPaiement = $result['idPaiement'];
            $this->idContrat = $result['idContrat'];
            $this->reglement = $result['Reglement'];
            $this->reçuTPE = $result['reçuTPE'];
            $this->jourReglement = $result['jourReglement'];

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
        $result = $this->query($sql, [':id' => $this->idPaiement], true); // Récupère un seul enregistrement correspondant
        $num = count($result);
        var_dump($num);

        if ($num == 1) {
            $this->idPaiement = $result[0][$this->id];
            $this->idContrat = $result[0]['idContrat'];
            $this->reglement = lireBoolSQL($result[0]['Reglement'], true);
            $this->reçuTPE = lireDateHeureSQL($result[0]['reçuTPE']);
            $this->jourReglement = lireSQL($result[0]['jourReglement']);

            $OK = true;
        }
        return $OK;
    }

    public function ecrire()
    {

        global $dbh;

        $sql = "INSERT INTO " . self::$table . " (idContrat, Reglement, reçuTPE, jourReglement, Duree)";
        $sql .= " VALUES ('" . $this->idContrat . "', " . ecritBoolSQL($this->reglement, true) . ", " . ecritDateHeureSQL($this->reçuTPE) . ", " . strToSQL($this->jourReglement) . ");";
        $result = $dbh->exec($sql);

        if ($result)
            $this->id = $dbh->lastInsertId();

        return $result;
    }

    public function update()
    {

        global $dbh;

        $sql = "UPDATE " . self::$table . " SET";
        $sql .= ", idContrat = '" . $this->idContrat . "'";
        $sql .= ", Reglement = " . ecritBoolSQL($this->reglement, true);
        $sql .= ", reçuTPE = " . ($this->reçuTPE);
		$sql .= ", jourReglement = '" . ecritDateHeureSQL($this->jourReglement);
        $sql .= ", Duree = " . strToSQL($this->jourReglement);
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