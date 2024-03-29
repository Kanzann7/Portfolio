<?php

namespace App\Controller\Admin;

use App\Model\UserModel;
use App\Model\SkillModel;
use App\Model\CategoryModel;
use App\Service\UserSession;
use App\Model\PortfolioModel;

class AdminMenuController
{
    public function validateSkillForm(string $image, string $content)
    {
        $image = false;
        $errors = [];
        if (array_key_exists('imageSkill', $_FILES) && $_FILES['imageSkill']['error'] != UPLOAD_ERR_NO_FILE) {
            // Validation du poids du fichier
            $image = true;
            $filesize = filesize($_FILES['imageSkill']['tmp_name']);
            if ($filesize > MAX_UPLOAD_SIZE) {
                $errors['imageSkill'] = 'Votre fichier excède 1 Mo.';
            }

            // Validation du type de fichier
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $mimeType = mime_content_type($_FILES['imageSkill']['tmp_name']);

            if (!in_array($mimeType, $allowedMimeTypes)) {
                $errors['imageSkill'] = 'Type de fichier non autorisé';
            }
        }

        if ((!$image) && empty($content)) {
            $errors['imageSkill'] = 'Veuillez remplir au moins un des champs !';
            $errors['contentSkill'] = 'Veuillez remplir au moins un des champs !';
        }
        return $errors;
    }

    function validatePortfolioForm(string $image, string $content)
    {
        $image = false;
        $errors = [];
        if (array_key_exists('imagePortfolio', $_FILES) && $_FILES['imagePortfolio']['error'] != UPLOAD_ERR_NO_FILE) {
            $image = true;
            $filesize = filesize($_FILES['imagePortfolio']['tmp_name']);
            if ($filesize > MAX_UPLOAD_SIZE) {
                $errors['imagePortfolio'] = 'Votre fichier excède 1 Mo.';
            }
            $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png'];
            $mimeType = mime_content_type($_FILES['imagePortfolio']['tmp_name']);

            if (!in_array($mimeType, $allowedMimeTypes)) {
                $errors['imagePortfolio'] = 'Type de fichier non autorisé';
            }
        }

        if ((!$image) || empty($content)) {
            $errors['imagePortfolio'] = 'Veuillez remplir les deux champs !';
            $errors['contentPortfolio'] = 'Veuillez remplir les deux champs !';
        }
        return $errors;
    }

    function index()
    {


        /* SKILLS */


        $imageSkill = '';
        $contentSkill = '';
        $skillModel = new SkillModel();
        $skills = $skillModel->getAllSkills();

        /* ADD SKILLS */

        if (isset($_POST['addSubmitSkill'])) {

            $contentSkill = trim($_POST['contentSkill']);

            $errors = $this->validateSkillForm($imageSkill, $contentSkill);




            if (empty($errors)) {


                $filename = '';

                if (array_key_exists('imageSkill', $_FILES) && $_FILES['imageSkill']['error'] != UPLOAD_ERR_NO_FILE) {

                    $extension = pathinfo($_FILES['imageSkill']['name'], PATHINFO_EXTENSION);
                    $basename = pathinfo($_FILES['imageSkill']['name'], PATHINFO_FILENAME);


                    // Clean filename
                    $basename = slugify($basename);

                    // Add random strings to avoid conflicts
                    $filename = $basename . sha1(uniqid(rand(), true)) . '.' . $extension;

                    // Copy temporary file in folder images
                    if (!file_exists('images')) {
                        mkdir('images');
                    }

                    move_uploaded_file($_FILES['imageSkill']['tmp_name'], 'images/' . $filename);
                }
                $skillModel->addSkill($filename, $contentSkill);
                $_SESSION['flash'] = 'Compétence ajoutée !';
                header('Location: ' . constructUrl('adminMenu'));
                exit;
            }
        }

        /* REMOVE SKILLS */
        foreach ($skills as $skill) {
            if (isset($_POST['removeSubmitSkill' . $skill->getId()])) {

                $skillModel->removeSkill($skill->getId());
                $_SESSION['flash'] = 'Compétence retirée !';
                header('Location: ' . constructUrl('adminMenu'));
                exit;
            }
        }


        /* PORTFOLIO */


        $imagePortfolio = '';
        $contentPortfolio = '';
        $portfolioModel = new PortfolioModel();
        $portfolios = $portfolioModel->getAllPortfolio();
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->getAllCategories();

        /* ADD PORTFOLIOS */

        if (isset($_POST['addSubmitPortfolio'])) {

            $contentPortfolio = trim($_POST['contentPortfolio']);
            $categoryId = (int) $_POST['category'];



            $errors = $this->validatePortfolioForm($imagePortfolio, $contentPortfolio);




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

                $portfolioModel->addPortfolio($filename, $contentPortfolio, $categoryId);
                $_SESSION['flash'] = 'Portfolio ajouté !';
                header('Location: ' . constructUrl('adminMenu'));
                exit;
            }
        }

        /* REMOVE PORTFOLIOS */
        foreach ($portfolios as $portfolio) {
            if (isset($_POST['removeSubmitPortfolio' . $portfolio->getId()])) {

                $portfolioModel->removePortfolio($portfolio->getId());
                $_SESSION['flash'] = 'Portfolio retiré !';
                header('Location: ' . constructUrl('adminMenu'));
                exit;
            }
        }


        if (isset($_SESSION['flash'])) {
            $message =  $_SESSION['flash'];
            $_SESSION['flash'] = null;
        }



        $template = "adminMenu";
        include TEMPLATE_DIR . "/admin/baseAdmin.phtml";
    }



    public function update()
    {

        /* UPDATE SKILLS */


        if (isset($_GET['skill'])) {
            $imageSkill = '';
            $contentSkill = '';
            $skillModel = new SkillModel();

            $skill = $skillModel->getOneSkill($_GET["skill"]);

            if (isset($_POST['updateSubmitSkill' . $skill->getId()])) {

                $contentSkill = trim($_POST['contentSkill']);

                $errors = $this->validateSkillForm($imageSkill, $contentSkill);


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
                    $skillModel->updateSkill($filename, $contentSkill, $skill->getId());
                    $_SESSION['flash'] = 'Compétence modifiée !';
                    header('Location: ' . constructUrl('adminMenu'));
                    exit;
                }
            }
        }




        /* UPDATE PORTFOLIO */

        if (isset($_GET['portfolio'])) {

            $imagePortfolio = '';
            $contentPortfolio = '';
            $portfolioModel = new PortfolioModel();
            $categoryModel = new CategoryModel();
            $categories = $categoryModel->getAllCategories();

            $portfolio = $portfolioModel->getOnePortfolio($_GET["portfolio"]);

            if (isset($_POST['updateSubmitPortfolio' . $portfolio->getId()])) {

                $categoryId = (int) $_POST['category'];
                $contentPortfolio = trim($_POST['contentPortfolio']);
                $errors = $this->validatePortfolioForm($imagePortfolio, $contentPortfolio);



                if (empty($errors)) {


                    $filename = '';

                    if (array_key_exists('imagePortfolio', $_FILES) && $_FILES['imagePortfolio']['error'] != UPLOAD_ERR_NO_FILE) {

                        // Clean filename
                        $extension = pathinfo($_FILES['imagePortfolio']['name'], PATHINFO_EXTENSION);
                        $basename = pathinfo($_FILES['imagePortfolio']['name'], PATHINFO_FILENAME);

                        // Filename 's slugification
                        $basename = slugify($basename);

                        // Add random string to avoid conflict
                        $filename = $basename . sha1(uniqid(rand(), true)) . '.' . $extension;

                        //Copy temporary file in "images" folder
                        if (!file_exists('images')) {
                            mkdir('images');
                        }

                        move_uploaded_file($_FILES['imagePortfolio']['tmp_name'], 'images/' . $filename);
                    }
                    $portfolioModel->updatePortfolio($filename, $contentPortfolio, $categoryId, $portfolio->getId());
                    $_SESSION['flash'] = 'Portfolio modifié !';
                    header('Location: ' . constructUrl('adminMenu'));
                    exit;
                }
            }
        }


        if (isset($_SESSION['flash'])) {
            $message =  $_SESSION['flash'];
            $_SESSION['flash'] = null;
        }

        $template = "updateSkillsAndPortfolios";
        include TEMPLATE_DIR . "/admin/baseAdmin.phtml";
    }
}
