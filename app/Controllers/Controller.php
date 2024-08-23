<?php

namespace App\Controllers;

use Database\DBConnection;

abstract class Controller {

    protected $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db;
    }

        protected function getDB()
    {
        return $this->db;
    }

}




// protected function view(string $path, string $params = null)
    // {
    //     ob_start(); // memoire tampon
    //     $path = str_replace('.', DIRECTORY_SEPARATOR, $path);
    //     require VIEWS . $path . '.php'; // = fichier views + blog/chemin + .php
    //     $content = ob_get_clean(); //clean la memoire et le transforme en string
    //     // require VIEWS . 'layout.php';
    // }

