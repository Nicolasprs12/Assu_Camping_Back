<?php

namespace Router;

use Database\DBConnection;

use App\Exceptions\NotFoundException;

class Route {

    public $path;
    public $action;

    public $matches;


    public function __construct($path, $action){
        $this->path = trim($path, '/');
        $this->action = $action;
    }

    public function matches(string $url){
        //path capture URL de façon dynamique
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $pathToMatch = "#^$path$#";
        //Verifie si l'url correspond à un chemin et resort un boolean
        if (preg_match($pathToMatch, $url, $matches)){
            // var_dump($matches);
            $this->matches = $matches;
            return true;
        }else{
                return false;
        }
        
    }
    
    public function execute(){
        $params = explode('@', $this->action); 
        $controller = new $params[0](new DBConnection(DB_NAME, DB_HOST, DB_USER, DB_PWD));
        $method = $params[1]; //$params[0] = /path  $params[1] = /action 
        
        if (!method_exists($controller, $method)) {
            throw new NotFoundException();
            // return;
        }
        
        return isset($this->matches[1]) ? $controller->$method($this->matches[1]) : $controller->$method();
    
    
    }
    
    
}
