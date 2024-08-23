<?php

namespace Router;


class Router
{

    public $url;

    public $routes = [];

    private $action;

    private $controller;

    public function __construct($url)
    {
        $this->url = trim($url, '/');
        $this->controller = 'App\Controllers\BlogController';
        
    }

    public function getControllerAction()
{
    $tabURL = explode('/', $this->url);
    $this->action = $tabURL[0];
    if (count($tabURL) > 1) {
        $extURL = '/:id'; 
    } else {
        $extURL = '';
    }
    $urlStr = '/' . $this->action . $extURL;

    if (empty ($this->action)) {
        $this->action = 'accueil';
        $urlStr = '';
    }

    // construct pour la function get
    $this->get($urlStr, $this->controller . '@' . $this->action);
}

    public function get(string $path, string $action)
    {
        $this->routes['GET'][] = new Route($path, $action);
        //Ajout route POST
        $this->routes['POST'][] = new Route($path, $action);
        
        $this->routes['PUT'][] = new Route($path, $action);
        
        $this->routes['DELETE'][] = new Route($path, $action);
    }

    public function run()
    {
        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->matches($this->url)) {
                return $route->execute();
            }
            ;
        }


    }

}