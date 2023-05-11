<?php

namespace App\Controller;

// Import de classes
use App\Model\PortfolioModel;
use App\Model\CommentModel;

class CommentsController
{
    function validateCommentForm(string $comment)
    {
        $errors = [];
        if (empty($comment)) {
            $errors['comment'] = "Le champ est vide !";
        }
        return $errors;
    }
    public function index()
    {
        //Url params validation
        if (!array_key_exists('id', $_GET) || !$_GET['id'] || !ctype_digit($_GET['id'])) {
            http_response_code(404);
            echo 'Article introuvable';
            exit; // End PHP script
        }

        $idPortfolio = (int) $_GET["id"];
        $portfolioModel = new PortfolioModel();
        $portfolioId = $portfolioModel->getOnePortfolio($idPortfolio);
        $commentModel = new CommentModel();

        if (!$portfolioId) {
            http_response_code(404);
            echo 'Portfolio introuvable (id ' . $idPortfolio . ')';
            exit;
        }





        if (!empty($_POST)) {

            $comment = $_POST['comment'];
            $errors = $this->validateCommentForm($comment);
            $usersId = $_SESSION['user']->getId();


            if (!(new \App\Service\UserSession())->getUser()) {
                $comment = $_POST['comment'];
                $_SESSION['flash'] = "Veuillez vous connecter";
                header('Location: ' . constructUrl('comments', ['id' => $idPortfolio]));
                exit;
            }





            if (!$errors) {
                $commentModel->addComment($comment, $usersId, $idPortfolio,);
                //message flash
                $_SESSION['flash'] = "Votre commentaire a bien été ajouté";

                //Redirection vers la page comments
                header('Location: ' . constructUrl('comments', ['id' => $idPortfolio]));
                exit;
            }
        }

        $comments = $commentModel->getCommentsByPortfolioId($idPortfolio);








        if (isset($_SESSION['flash'])) {
            $message =  $_SESSION['flash'];
            $_SESSION['flash'] = null;
        }


        $template = "comments";
        include TEMPLATE_DIR . '/base.phtml';
    }
}
