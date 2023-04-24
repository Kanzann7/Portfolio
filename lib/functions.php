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
