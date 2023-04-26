<?php

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


function validateCommentForm(string $pseudo, string $comment)
{
    $errors = [];
    if (empty($pseudo)) {
        $errors['pseudo'] = "Le champ est vide !";
    }
    if (empty($comment)) {
        $errors['comment'] = "Le champ est vide !";
    }
    return $errors;
}

function emailExists(string $email, array $users): bool
{
    // On vérifie l'existance de l'email seulement si celui-ci est rempli et valide
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            return true;
        }
    }

    return false;
}

function validateInscriptionForm(string $email, string $pseudo, string $password)
{
    $errors = [];
    if (empty($email)) {
        $errors['email'] = "Veuillez saisir une adresse mail valide !";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Veuillez remplir un email valide';
    } elseif (emailExists($email, $users)) {
        $errors['email'] = 'Un compte existe déjà avec cet email';
    }
    if (empty($pseudo)) {
        $errors['pseudo'] = "Veuillez saisir un pseudo !";
    }
    if (empty($password)) {
        $errors['password'] = "Veuillez choisir un mot de passe";
    }
}
