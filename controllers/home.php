<?php

use App\Model\PortfolioModel;
use App\Model\SkillModel;

$portfolioModel = new PortfolioModel;
$portfolios = $portfolioModel->getAllPortfolio();

$skillModel = new SkillModel;

$skills = $skillModel->getAllSkills();




$template = "home";
include '../templates/base.phtml';
