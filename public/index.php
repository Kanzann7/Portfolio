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
        break;

    case '/deconnexion';
        require '../controllers/deconnexion.php';
        break;

    case '/mentions-legales';
        require '../controllers/mentionsLegales.php';
        break;

    case '/comments';
        require '../controllers/comments.php';
        break;

    case '/adminLogin';
        require '../controllers/adminLogin.php';
        break;

    case '/adminMenu';
        require '../controllers/adminMenu.php';
        break;

    default:
        http_response_code(404);
        echo 'Page introuvable';
        exit;
}
