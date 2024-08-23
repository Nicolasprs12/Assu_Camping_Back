<?php

namespace App\Models;

class Version extends Model {

    protected $table = 'version';
    protected $id = 'idVersion ';

	private $idVersion ;				// nombre
	private $Version;					// chaîne de caractères
	private $Carroserie;				// chaîne de caractères
	private $PuissanceFisc;				// chaîne de caractères
	private $Energie;					// chaîne de caractères


}