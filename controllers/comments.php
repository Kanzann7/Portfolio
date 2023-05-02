<?php


use App\Model\CommentModel;
use App\Model\PortfolioModel;


//Url params validation

if (!array_key_exists('id', $_GET) || !$_GET['id'] || !ctype_digit($_GET['id'])) {
    http_response_code(404);
    echo 'Commentaires introuvable';
    exit; // End PHP script
}

$idPortfolio = (int) $_GET["id"];
$portfolioModel = new PortfolioModel();
$portfolioId = $portfolioModel->getOnePortfolio($idPortfolio);
$commentModel = new CommentModel();

if (!$portfolioId) {
    http_response_code(404);
    echo 'Article introuvable (id ' . $idPortfolio . ')';
    exit;
}


if (!empty($_POST)) {

    $comment = $_POST['comment'];

    $errors = validateCommentForm($comment);
    $usersId = $_SESSION['user']['userId'];





    if (!$errors) {
        $commentModel->addComment($comment, $usersId, $idPortfolio,);
        //message flash
        $_SESSION['flashbag'] = "Votre commentaire a bien été ajouté";

        //Redirection vers la page comments
        header('Location: ' . constructUrl('/comments', ['id' => $idPortfolio]));
        exit;
    }
}

$comments = $commentModel->getCommentsByPortfolioId($idPortfolio);




if (array_key_exists('flashbag', $_SESSION) && $_SESSION['flashbag']) {
    $flashMessage = $_SESSION['flashbag'];
    $_SESSION['flashbag'] = null;
}






$template = "comments";
include "../templates/base.phtml";
