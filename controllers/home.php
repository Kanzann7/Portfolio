<?php


use App\Model\PortfolioModel;
use App\Model\SkillModel;

$portfolioModel = new PortfolioModel;
$portfolios = $portfolioModel->getAllPortfolio();

$skillModel = new SkillModel;
$skills = $skillModel->getAllSkills();

if (isset($_SESSION['flash'])) {
    $message =  $_SESSION['flash'];
    $_SESSION['flash'] = null;
}






$template = "home";
include '../templates/base.phtml';
