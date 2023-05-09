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
    $imageSkill = trim($_POST['imageSkill']);
    $contentSkill = trim($_POST['contentSkill']);

    $errors = validateSkillForm($imageSkill, $contentSkill);


    if (empty($errors)) {
        $skillModel->addSkill($imageSkill, $contentSkill);
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

/* ADD PORTFOLIO */

if (isset($_POST['addSubmitPortfolio'])) {


    $imagePortfolio = trim($_POST['imagePortfolio']);
    $contentPortfolio = trim($_POST['contentPortfolio']);

    $errors = validatePortfolioForm($imagePortfolio, $contentPortfolio);

    if (empty($errors)) {
        $portfolioModel->addPortfolio($imagePortfolio, $contentPortfolio);
        $_SESSION['flash'] = 'Portfolio ajouté !';
        header('Location: ' . constructUrl('/adminMenu'));
        exit;
    }
}

/* REMOVE PORTFOLIO */

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
