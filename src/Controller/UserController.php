<?php

namespace App\Controller;

use App\Entity\User;
use App\Model\UserModel;
use App\Service\Enum\UserRole;

class UserController
{

    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function signup()
    {
        $pseudo = '';
        $email = '';

        // Si le formulaire est soumis
        if (!empty($_POST)) {

            // 1. Récupération des données du formulaire
            $pseudo = strip_tags(trim($_POST['pseudo']));
            $email = strip_tags(trim($_POST['email']));
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password-confirm'];

            // 2. Validation du formulaire
            $errors = $this->validateForm(
                $pseudo,
                $email,
                $password,
                $passwordConfirm
            );

            // Si il n'y a pas d'erreur... 
            if (empty($errors)) {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User([
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $hash,
                    'role' => UserRole::USER
                ]);



                $this->userModel->addUser($user);


                // Ajout d'un message flash en session
                $_SESSION['flash'] = 'Votre compte a été créé avec succès.';


                header('Location: ' . constructUrl('home'));
                exit;
            }
        }

        // Affichage du template
        $template = 'inscription';
        include TEMPLATE_DIR . '/base.phtml';
    }

    private function validateForm(
        string $pseudo,
        string $email,
        string $password,
        string $passwordConfirm
    ) {
        // On initialise un tableau, on stockera les messages d'erreur dedans
        $errors = [];

        // Si le champ "firstname" n'est pas rempli...
        if (!$pseudo) {
            $errors['pseudo'] = 'Veuillez remplir le champ "Pseudo"';
        }

        // Validation de l'email
        if (!$email) {
            $errors['email'] = 'Veuillez remplir le champ "Email"';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Veuillez remplir un email valide';
        } elseif ($this->userModel->getUserByEmailAndPseudo($email, $pseudo)) {
            $errors['email'] = 'Un compte existe déjà avec cet email';
        }

        if (strlen($password) < 8) {
            $errors['password'] = 'Le mot de passe doit comporter au moins 8 caractères';
        } elseif ($password != $passwordConfirm) {
            $errors['password-confirm'] = 'La confirmation ne correspond pas';
        }

        // On retourne le tableau d'erreurs
        return $errors;
    }
}
