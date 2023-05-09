<?php

use App\Model\UserModel;

function asset(string $path)
{
    return BASE_URL . '/' . $path;;
}


function constructUrl(string $path, array $params = [])
{
    $url = BASE_URL . '/index.php' . $path;

    if ($params) {
        $url .= '?' . http_build_query($params);
    }
    return $url;
}


function validateCommentForm(string $comment)
{
    $errors = [];
    if (empty($comment)) {
        $errors['comment'] = "Le champ est vide !";
    }
    return $errors;
}

function isConnected(): bool
{
    /**
     * @TODO Vérifier que la session à démarré
     */
    return array_key_exists('user', $_SESSION) && $_SESSION['user'];
}


function validateInscriptionForm(string $email, string $pseudo, string $password, string $passwordConfirm)
{

    $userModel = new UserModel();

    $errors = [];
    if (empty($email)) {
        $errors['email'] = "Veuillez saisir une adresse mail valide !";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Veuillez saisir une adresse mail valide !';
    } elseif ($userModel->emailExists($email)) {
        $errors['email'] = 'Un compte existe déjà avec cet email !';
    }
    if (empty($pseudo)) {
        $errors['pseudo'] = "Veuillez saisir un pseudo !";
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Le mot de passe doit comporter au moins 8 caractères !';
    } elseif ($password != $passwordConfirm) {
        $errors['password-confirm'] = 'Les deux mots de passe ne correspondent pas !';
    }
    return $errors;
}

function validateSkillForm(string $image, string $content)
{
    $errors = [];

    if (empty($image) && empty($content)) {
        $errors = 'Veuillez remplir au moins un des champs !';
    }
    return $errors;
}

function validatePortfolioForm(string $image, string $content)
{
    $errors = [];

    if (empty($image) || empty($content)) {
        $errors = "Vous devez remplir ces deux champs !";
    }
    return $errors;
}




function checkCredentials($email, $pseudo, $password)
{
    $userModel = new UserModel();

    $user = $userModel->getUserByEmail($email);

    if (!$user) {
        return false;
    }

    $user = $userModel->getUserByPseudo($pseudo);

    if (!$user) {
        return false;
    }

    if (!password_verify($password, $user['password'])) {
        return false;
    }


    return $user;
}
