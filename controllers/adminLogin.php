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

    //Est-ce que les identifiants sont corrects ?
    $user = checkCredentials($email, $pseudo, $password);

    if (!$user) {
        $errors = 'Identifiants incorrects';
    } else {
        $userCredentials = new User($user);
        $userPseudo = $userCredentials->getPseudo();
        $passwordHash = $userCredentials->getPassword();
        $userRole = $userCredentials->getRole();

        // Checking role

        if ($userRole == "user") {
            $errors = "Vous n'êtes pas autorisé à consulter cette page !";
        }


        if ($errors == null) {

            // 2. Enregistrer l'utilisateur en session
            $_SESSION['user'] = [
                'email' => $user['email'],
                'pseudo' => $user['pseudo'],
                'userId' => $user['id'],
                'role' => $user['role']
            ];

            // Message flash de succès


            // Redirection vers la page d'accueil
            header('Location: ' . constructUrl('/adminMenu'));
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
