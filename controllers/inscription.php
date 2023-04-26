<?php

session_start();


$email = '';
$pseudo = '';

if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = trim($_POST['password']);

    $errors = validateInscriptionForm();
}



$template = "inscription";
include '../templates/base.phtml';
