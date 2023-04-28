<?php


$_SESSION['user'] = null;

// Message flash
$_SESSION['flash'] = 'Vous vous êtes bien déconnecté';

// On ferme la session
session_destroy();

// redirection
header('Location: ' . constructUrl('/'));
exit;
