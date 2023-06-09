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
        // If form is submit
        if (!empty($_POST)) {

            // Recover data form
            $pseudo = strip_tags(trim($_POST['pseudo']));
            $email = strip_tags(trim($_POST['email']));
            $password = $_POST['password'];
            $passwordConfirm = $_POST['password-confirm'];

            // Form validation
            $errors = $this->validateForm(
                $pseudo,
                $email,
                $password,
                $passwordConfirm
            );

            // If no errors
            if (empty($errors)) {

                $hash = password_hash($password, PASSWORD_DEFAULT);

                $user = new User([
                    'pseudo' => $pseudo,
                    'email' => $email,
                    'password' => $hash,
                    'role' => UserRole::USER
                ]);

                $this->userModel->addUser($user);
                // Add flash message
                $_SESSION['flash'] = 'Votre compte a été créé avec succès.';
                header('Location: ' . constructUrl('home'));
                exit;
            }
        }

        // Display flash message
        $template = 'inscription';
        include TEMPLATE_DIR . '/base.phtml';
    }

    private function validateForm(
        string $pseudo,
        string $email,
        string $password,
        string $passwordConfirm
    ) {
        // Initialize an array to store errors
        $errors = [];

        // If the field "pseudo" is empty
        if (!$pseudo) {
            $errors['pseudo'] = 'Veuillez remplir le champ "Pseudo"';
        }

        // Email validation
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

        // Return array of errors
        return $errors;
    }
}
