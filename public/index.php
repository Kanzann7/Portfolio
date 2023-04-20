<?php
session_start();

require '../vendor/autoload.php';
require '../app/config.php';
require '../lib/functions.php';


$path = (str_replace(BASE_URL, '', $_SERVER['REQUEST_URI']));
$path = (str_replace('/index.php', '', $path));
$path = explode('?', $path)[0];

if ($path == "") {
    $path = "/";
}


// Routing
switch ($path) {
    case '/';
        require '../controllers/home.php';
        break;
    case '/connexion';
        require '../controllers/connexion.php';
        break;
    case '/inscription';
        require '../controllers/inscription.php';

    default:
        http_response_code(404);
        echo 'Page introuvable';
        exit;
}
