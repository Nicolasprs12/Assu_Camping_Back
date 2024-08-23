<?php

namespace App\Models;

class Pays extends Model {

    protected $table = 'pays';
    protected $id = 'idPays';

	private $idPays ;						// nombre
	private $code ;						// chaîne de caractères
	private $alpha2;						// nombre
	private $alpha3;						// nombre
	private $nom_en_gb;						// nombre
	private $nom_fr_fr;						// nombre
	

}