<?php


use App\Model\CommentModel;
use App\Model\PortfolioModel;
use App\Model\SkillModel;

//Url params validation

if (!array_key_exists('id', $_GET) || !$_GET['id'] || !ctype_digit($_GET['id'])) {
    http_response_code(404);
    echo 'Article introuvable';
    exit; // Fin de l'exécution du script PHP
}







$template = "comments";
include "../templates/base.phtml";
