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
        // If form is submit
        if (!empty($_POST)) {

            // Recover data form
            $pseudo = strip_tags(trim($_POST['pseudo']));
            $email = strip_tags(trim($_POST['email']));
            $password = $_POST['password'];

            //  Check if credentials are correct
            $user = $this->checkCredentials($email, $pseudo, $password);


            if (!$user) {
                $errors = 'Identifiants incorrects';
            }

            // If credentials are correct
            else {

                // 2. Register user in session
                $userSession = new UserSession();
                $userSession->register($user);

                // Message flash de succès
                $_SESSION['flash'] = 'Content de te revoir ' . $user->getPseudo();

                // Redirect to the home page
                header('Location: ' . constructUrl('home'));
                exit;
            }
        }

        // Display template
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
        // Delete data recorded in session
        $_SESSION['user'] = null;

        // Flash message
        $_SESSION['flash'] = 'Vous vous êtes bien déconnecté .';

        // redirection
        header('Location: ' . constructUrl('home'));
        exit;
    }
}
