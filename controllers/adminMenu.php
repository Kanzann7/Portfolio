<?php

use App\Model\PortfolioModel;
use App\Model\SkillModel;
use App\Model\UserModel;

$userModel = new UserModel();
$user = $_SESSION['user'] ?? null;
if (!$user || $user['role'] !== 'admin') {
    http_response_code(404);
    echo "Accès interdit !";
    exit;
}

/* SKILLS */

$imageSkill = '';
$contentSkill = '';
$skillModel = new SkillModel();
$skills = $skillModel->getAllSkills();

/* ADD SKILLS */

if (isset($_POST['addSubmitSkill'])) {

    $contentSkill = trim($_POST['contentSkill']);

    $errors = validateSkillForm($imageSkill, $contentSkill);




    if (empty($errors)) {


        $filename = '';

        if (array_key_exists('imageSkill', $_FILES) && $_FILES['imageSkill']['error'] != UPLOAD_ERR_NO_FILE) {

            // Nettoyer le nom du fichier
            $extension = pathinfo($_FILES['imageSkill']['name'], PATHINFO_EXTENSION);
            $basename = pathinfo($_FILES['imageSkill']['name'], PATHINFO_FILENAME);

            // Slugification du nom du fichier (on supprime caractères spéciaux, accents, majuscules, espaces, etc)
            $basename = slugify($basename);

            // On ajoute une chaîne aléatoire pour éviter les conflits
            $filename = $basename . sha1(uniqid(rand(), true)) . '.' . $extension;

            // Copier le fichier temporaire dans notre dossier "images"
            if (!file_exists('images')) {
                mkdir('images');
            }

            move_uploaded_file($_FILES['imageSkill']['tmp_name'], 'images/' . $filename);
        }
        $skillModel->addSkill($filename, $contentSkill);
        $_SESSION['flash'] = 'Compétence ajoutée !';
        header('Location: ' . constructUrl('/adminMenu'));
        exit;
    }
}

/* REMOVE SKILLS */
foreach ($skills as $skill) {
    if (isset($_POST['removeSubmitSkill' . $skill->getId()])) {

        $skillModel->removeSkill($skill->getId());
        $_SESSION['flash'] = 'Compétence retirée !';
        header('Location: ' . constructUrl('/adminMenu'));
        exit;
    }
}

/* PORTFOLIO */


$imagePortfolio = '';
$contentPortfolio = '';
$portfolioModel = new PortfolioModel();
$portfolios = $portfolioModel->getAllPortfolio();

/* ADD PORTFOLIOS */

if (isset($_POST['addSubmitPortfolio'])) {

    $contentPortfolio = trim($_POST['contentPortfolio']);

    $errors = validatePortfolioForm($imagePortfolio, $contentPortfolio);




    if (empty($errors)) {


        $filename = '';

        if (array_key_exists('imagePortfolio', $_FILES) && $_FILES['imagePortfolio']['error'] != UPLOAD_ERR_NO_FILE) {

            // Nettoyer le nom du fichier
            $extension = pathinfo($_FILES['imagePortfolio']['name'], PATHINFO_EXTENSION);
            $basename = pathinfo($_FILES['imagePortfolio']['name'], PATHINFO_FILENAME);

            // Slugification du nom du fichier (on supprime caractères spéciaux, accents, majuscules, espaces, etc)
            $basename = slugify($basename);

            // On ajoute une chaîne aléatoire pour éviter les conflits
            $filename = $basename . sha1(uniqid(rand(), true)) . '.' . $extension;

            // Copier le fichier temporaire dans notre dossier "images"
            if (!file_exists('images')) {
                mkdir('images');
            }

            move_uploaded_file($_FILES['imagePortfolio']['tmp_name'], 'images/' . $filename);
        }
        $portfolioModel->addPortfolio($filename, $contentPortfolio);
        $_SESSION['flash'] = 'Compétence ajoutée !';
        header('Location: ' . constructUrl('/adminMenu'));
        exit;
    }
}

/* REMOVE SKILLS */
foreach ($portfolios as $portfolio) {
    if (isset($_POST['removeSubmitPortfolio' . $portfolio->getId()])) {

        $portfolioModel->removePortfolio($portfolio->getId());
        $_SESSION['flash'] = 'Portfolio retiré !';
        header('Location: ' . constructUrl('/adminMenu'));
        exit;
    }
}









if (isset($_SESSION['flash'])) {
    $message =  $_SESSION['flash'];
    $_SESSION['flash'] = null;
}



$template = "adminMenu";
include "../templates/baseAdmin.phtml";
