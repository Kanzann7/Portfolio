<?php

use App\Model\UserModel;

$email = '';
$pseudo = '';

$userModel = new UserModel();

if (!empty($_POST)) {
    $email = trim($_POST['email']);
    $pseudo = trim($_POST['pseudo']);
    $password = trim($_POST['password']);
    $passwordConfirm = $_POST["password-confirm"];

    $errors = validateInscriptionForm($email, $pseudo, $password, $passwordConfirm);

    if (empty($errors)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $userModel->addUser($pseudo, $email, $hash);
        $_SESSION['flash'] = 'Votre compte a été créé avec succès.';
        header('Location: ' . constructUrl('/'));
        exit;
    }
}



$template = "inscription";
include '../templates/base.phtml';
