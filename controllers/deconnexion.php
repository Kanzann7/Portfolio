<?php


$_SESSION['user'] = null;

// Message flash
$_SESSION['flash'] = 'Vous vous êtes bien déconnecté';


// redirection
header('Location: ' . constructUrl('/'));
exit;
