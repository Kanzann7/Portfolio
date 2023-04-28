<?php

$errors = null;
$email = '';
$pseudo = '';

if (!empty($_POST)) {

    // Récupération des données du formulaire
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // 1. Est-ce que les identifiants sont corrects ?
    $user = checkCredentials($email, $password);

    if (!$user) {
        $errors = 'Identifiants incorrects';
    }

    // Identifiants corrects
    if ($errors == null) {

        // 2. Enregistrer l'utilisateur en session
        $_SESSION['user'] = [
            'email' => $user['email'],
            'pseudo' => $user['pseudo'],
            'userId' => $user['id']
        ];

        // Message flash de succès
        $_SESSION['flash'] = 'Content de te revoir ' . $user['pseudo'];

        // Redirection vers la page d'accueil
        header('Location: ' . constructUrl('/'));
        exit;
    }
}

$template = "connexion";
include "../templates/base.phtml";
