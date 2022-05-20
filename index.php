<?php

use Knetwork\Models\User;
use Knetwork\Controllers\UserController;
use Knetwork\Controllers\FrontController;
use Knetwork\Controllers\ArticleController;
use Knetwork\Controllers\CommentController;

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set('Europe/Paris');

/* TODO:
- Chart commentaires
- Likes
- Helpers
- Services
- Réécriture des urls (.htaccess)
*/

// On démarre la session
session_start();

// on setup les variables d'environnements si on est en développement
if ($_SERVER['HTTP_HOST'] != "address.site.com") {
    $dotenv = \Dotenv\Dotenv::createImmuTable("./");
    $dotenv->load();
}

// Gestion des warnings
function errorHandler($errno, $errstr, $errfile, $errline) {
    throw new Exception($errstr, $errno);
}
set_error_handler('errorHandler');

// Initialisation du package Whoops pour simplifier la gestion des erreurs en environnement de développement
function eCatcher($e) {
    if ($_ENV['APP_ENV'] == 'development') {
        $whoops = new \Whoops\Run;
        $whoops->allowQuit(false);
        $whoops->writeToOutput(false);
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $html = $whoops->handleException($e);

        require 'whoops.php';
    }
}

// Routeur
try {
    // On récupère les controllers
    $frontController = new FrontController();
    $userController = new UserController();
    $articleController = new ArticleController();
    $commentController = new CommentController();

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche soit la page login ou home en fonction si il y a une session de setup ou pas
    if (isset($_GET['action'])) {

        //*************************** GESTION DE L'ENREGISTREMENT D'UN COMPTE **********************************/
        
        // Affichage de la page d'enregistrement de compte
        if ($_GET['action'] == 'register') {
            $frontController->register();
        }
        // Traitement de l'enregistrement d'un nouveau compte
        else if ($_GET['action'] == 'registerpost') {
            $data = [
                'lastname' => htmlspecialchars($_POST['lastname']),
                'firstname' => htmlspecialchars($_POST['firstname']),
                'email' => htmlspecialchars($_POST['email']),
                'password' => htmlspecialchars($_POST['password']),
                'confirmPassword' => htmlspecialchars($_POST['confirm_password']),
                'birthday' => htmlspecialchars($_POST['birthday']),
                'imageProfile' => $_FILES['image_profile']
            ];

            $userController->register($data);
        }

        //*************************** GESTION DE LA CONNEXION **********************************/

        // Traitement de la connexion à un compte
        else if ($_GET['action'] == 'loginpost') {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $userController->login($email, $password);
        }
        // Déconnexion
        else if ($_GET['action'] == 'disconnect') {
            session_destroy();
            header('location: index.php');
        }

        //*************************** GESTION DES ARTICLES **********************************/

        // Nouvel article
        else if ($_GET['action'] == 'newarticle') {
            $userController->auth();

            // Si il y a aucun contenu, on redirige vers l'index
            if ($_POST['new-article-edit'] == "" && $_FILES['image-article']['size'][0] == 0) {
                header("Location: index.php");
            }

            // On enregistre le nouvel article
            if ($_POST['new-article-edit'] != "" || $_FILES['image-article']['size'][0] != 0) {
                $content = htmlspecialchars($_POST['new-article-edit']);
                $articleController->addArticle($content, $_FILES['image-article']);
            } else {
                throw new Exception("Erreur lors de la création de l'article", 3);
            }
        }
        // Modification d'article
        else if ($_GET['action'] == 'modifyarticle') {
            $userController->auth();

            $content = htmlspecialchars($_POST['article-edit-' . $_GET['id']]);
            $articleController->modifyArticle($_GET['id'], $content);
        }
        // Suppression d'article
        else if ($_GET['action'] == 'deletearticle') {
            $userController->auth();

            $articleController->deleteArticle($_GET['id']);
        }

        //************************* GESTION DES COMMENTAIRES ********************************/

        // Novueau commentaire
        else if ($_GET['action'] == 'newcomment') {
            $userController->auth();

            // Si il n'y a aucun contenu, on regirige vers l'index
            if (empty($_POST['new-comment-edit'])) {
                header('Location: index.php');
            } else {
                // On enregistre le nouveau commentaire
                $comment = htmlspecialchars($_POST['new-comment-edit']);
                $commentController->addComment($comment, $_GET['idarticle']);
            }
        }
        // Modification d'un commentaire
        else if ($_GET['action'] == 'modifycomment') {
            $userController->auth();

            $content = htmlspecialchars($_POST['comment-edit-' . $_GET['id']]);
            $commentController->modifyComment($_GET['id'], $content);
        }
        // Suppression d'un commentaire
        else if ($_GET['action'] == 'deletecomment') {
            $userController->auth();

            $commentController->deleteComment($_GET['id']);
        }

        //*************************** GESTION DU PROFIL **********************************/
        
        // Affichage de la page de profil
        else if ($_GET['action'] == 'profile') {
            $userController->auth();

            $frontController->profile(isset($_GET['id']) ? $_GET['id'] : $_SESSION['id']);
        }

    } else {
        // On check si une session existe
        // Si oui, on affiche la page accueil
        // Si non, on affiche la pge de login
        if (isset($_SESSION['id'])) {
            // On vérifie que l'utilisateur est valide
            try {
                $userController->auth();

                $frontController->home();
            } catch (\Exception $e) {
                $frontController->login($e);
            }
        } else {
            $frontController->login();
        }
    }
}
catch (\Exception $e) {
    eCatcher($e);
    include 'app/views/front/error.php';
}
catch (\Error $e) {
    eCatcher($e);
    include 'app/views/front/error.php';
}
