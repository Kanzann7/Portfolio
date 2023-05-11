<?php

namespace App\Controller;

// Import de classes
use App\Model\PortfolioModel;
use App\Model\SkillModel;

class HomeController
{

    public function index()
    {
        $portfolioModel = new PortfolioModel;
        $portfolios = $portfolioModel->getAllPortfolio();

        $skillModel = new SkillModel;
        $skills = $skillModel->getAllSkills();

        // Messages flash
        if (array_key_exists('flash', $_SESSION) && $_SESSION['flash']) {
            $flashMessage = $_SESSION['flash'];
            $_SESSION['flash'] = null;
        }

        // Affichage : inclusion du template
        $template = 'home';
        include TEMPLATE_DIR . '/base.phtml';
    }
}
