<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Model\UserModel;
use App\Service\UserSession;

class AdminLoginController
{
    function index()
    {
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

        $errors = null;
        $email = '';
        $pseudo = '';

        if (!empty($_POST)) {

            // Récupération des données du formulaire
            $email = $_POST['email'];
            $pseudo = $_POST['pseudo'];
            $password = $_POST['password'];

            $userModel = new UserModel();
            $user = $userModel->getUserByEmailAndPseudo($email, $pseudo);

            //Est-ce que les identifiants sont corrects ?
            $user = checkCredentials($email, $pseudo, $password);

            if (!$user) {
                $errors = 'Identifiants incorrects';
            } else {

                $userPseudo = $user->getPseudo();
                $passwordHash = $user->getPassword();
                $userRole = $user->getRole();

                // Checking role
                $userSession = new UserSession();



                if ($errors == null) {

                    $userSession->register($user);
                        // 2. Enregistrer l'utilisateur en session

                    ;

                    // Message flash de succès


                    // Redirection vers la page d'accueil
                    header('Location: ' . constructUrl('adminMenu'));
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
        include TEMPLATE_DIR . "/admin/baseAdmin.phtml";
    }
}
