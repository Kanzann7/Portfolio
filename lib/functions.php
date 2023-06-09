<?php

function asset(string $path)
{
    return BASE_URL . '/' . $path;
}

function constructUrl(string $routeName, array $params = [])
{
    // If root doesn't exists, we launch an exception
    if (!array_key_exists($routeName, ROUTES)) {
        throw new Exception('ERREUR : pas de route nommée ' . $routeName);
    }

    $url = BASE_URL . '/index.php' . ROUTES[$routeName]['path'];

    if ($params) {
        $url .= '?' . http_build_query($params);
    }

    return $url;
}

function slugify($string)
{
    // Remplace les caractères spéciaux par des tirets
    $string = preg_replace('/[^\p{L}\p{N}]+/u', '-', $string);

    // Convertit en minuscules
    $string = mb_strtolower($string, 'UTF-8');

    // Supprime les tirets en début et fin de chaîne
    $string = trim($string, '-');

    // Supprime les tirets répétés
    $string = preg_replace('/-+/', '-', $string);

    return $string;
}
