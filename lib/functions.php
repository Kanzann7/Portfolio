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
        $errors['comment'] = "Le champ est vide";
    }
    return $errors;
}
