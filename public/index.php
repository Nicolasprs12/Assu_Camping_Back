<?php

use Router\Router;
use App\Exceptions\NotFoundException;
use App\Controllers\BlogController;

require '../vendor/autoload.php';
include '../app/Models/Function.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

define('DB_NAME', 'assu_camping');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PWD', 'Kdotebc1256!');


$router = new Router($_GET['url']);
$router->getControllerAction();

try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}











// define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
// define('SCRIPTS', dirname($_SERVER['SCRIPT_NAME']) . DIRECTORY_SEPARATOR);

// session_start();

// // Durée maximale de la session en secondes (5 heures)
// $maxSessionDuration = 5 * 60 * 60;

// // Vérifier si la session a été initialisée
// if (isset($_SESSION['LAST_ACTIVITY'])) {
//     // Temps écoulé depuis la dernière activité
//     $elapsedTime = time() - $_SESSION['LAST_ACTIVITY'];

//     if ($elapsedTime > $maxSessionDuration) {
//         session_destroy();   
//         header("Location: /path/to/login/page.php"); 
//         exit();
//     } else {
//         // Réinitialiser le délai de session
//         $_SESSION['LAST_ACTIVITY'] = time();
//         session_write_close();
//     }
// } else {
//     // Si c'est la première fois que la session est initialisée, définir LAST_ACTIVITY
//     $_SESSION['LAST_ACTIVITY'] = time();
//     session_write_close();
// }






















