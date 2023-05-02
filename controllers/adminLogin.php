<?php

use App\Entity\User;
use App\Model\UserModel;

$errors = null;
$email = '';
$pseudo = '';

if (!empty($_POST)) {

    // Récupération des données du formulaire
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    $userModel = new UserModel();
    $user = $userModel->getUserByEmail($email);

    // 1. Est-ce que les identifiants sont corrects ?
    $user = checkCredentials($email, $password);

    if (!$user) {
        $errors = 'Identifiants incorrects';
    } else {
        $userPassword = new User($user);
        $passwordHash = $userPassword->getPassword();
        $userRole = $userPassword->getRole();

        if (!$userRole == "user") {
            $errors = "Vous n'êtes pas autorisé à consulter cette page !";
        }

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
    // Identifiants corrects

}

if (isset($_SESSION['flash'])) {
    $message =  $_SESSION['flash'];
    $_SESSION['flash'] = null;
}



$template = "adminLogin";
include "../templates/baseAdmin.phtml";
