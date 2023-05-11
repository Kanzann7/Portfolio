<?php

namespace App\Controller;

use App\Model\UserModel;
use App\Service\UserSession;

class AuthController
{

    public function login()
    {
        $errors = null;
        $email = "";
        $pseudo = '';
        // Si le formulaire est soumis...
        if (!empty($_POST)) {

            // Récupération des données du formulaire
            $pseudo = $_POST['pseudo'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // 1. Est-ce que les identifiants sont corrects ?
            $user = $this->checkCredentials($email, $pseudo, $password);


            if (!$user) {
                $errors = 'Identifiants incorrects';
            }

            // Identifiants corrects
            else {

                // 2. Enregistrer l'utilisateur en session
                $userSession = new UserSession();
                $userSession->register($user);

                // Message flash de succès
                $_SESSION['flash'] = 'Content de te revoir ' . $user->getPseudo();

                // Redirection vers la page d'accueil
                header('Location: ' . constructUrl('home'));
                exit;
            }
        }

        // Affichage du template
        $template = 'login';
        include TEMPLATE_DIR . '/base.phtml';
    }

    function checkCredentials($email, $pseudo, $password)
    {
        $userModel = new UserModel();

        $user = $userModel->getUserByEmailAndPseudo($email, $pseudo);

        if (!$user) {
            return false;
        }



        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        return $user;
    }


    public function logout()
    {
        // On efface les données enregistrées en session
        $_SESSION['user'] = null;

        // Message flash
        $_SESSION['flash'] = 'Vous vous êtes bien déconnecté .';

        // redirection
        header('Location: ' . constructUrl('home'));
        exit;
    }
}
