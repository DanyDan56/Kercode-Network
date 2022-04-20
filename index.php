<?php

use Knetwork\Models\User;
use Knetwork\Controllers\UserController;
use Knetwork\Controllers\FrontController;
use Knetwork\Controllers\ArticleController;

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

/* TODO:
- Responsive Design
- Remplacer les onclic par des eventListener
- Sécurité utilisateurs
- Helpers
- Services
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

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche soit la page login ou home en fonction si il y a une session de setup ou pas
    if (isset($_GET['action'])) {

        //*************************** GESTION DE L'ENREGISTREMENT **********************************/
        
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
            // On check l'utilisateur
            User::check($_SESSION['id'], $_SESSION['password']) ?? throw new Exception("L'utilisateur n'est pas valide", 3);

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
            // On check l'utilisateur
            User::check($_SESSION['id'], $_SESSION['password']) ?? throw new Exception("L'utilisateur n'est pas valide", 3);

            $content = htmlspecialchars($_POST['article-edit-' . $_GET['id']]);
            $articleController->modifyArticle($_GET['id'], $content);
        }
        // Suppression d'article
        else if ($_GET['action'] == 'deletearticle') {
            // On check l'utilisateur
            User::check($_SESSION['id'], $_SESSION['password']) ?? throw new Exception("L'utilisateur n'est pas valide", 3);

            $articleController->deleteArticle($_GET['id']);
        }

        //*************************** GESTION DU PROFIL **********************************/
        
        // Affichage de la page de profil
        else if ($_GET['action'] == 'profile') {
            // On check l'utilisateur
            User::check($_SESSION['id'], $_SESSION['password']) ?? throw new Exception("L'utilisateur n'est pas valide", 3);

            $frontController->profile();
        }

    } else {
        // On check si une session existe
        // Si oui, on affiche la page accueil
        // Si non, on affiche la pge de login
        if (isset($_SESSION['id'])) {
            // On vérifie que l'utilisateur est valide
            try {
                if (\Knetwork\Models\User::check($_SESSION['id'], $_SESSION['password'])) {
                    $frontController->home();
                } else {
                    throw new Exception("L'utilisateur n'est pas valide", 3);
                }
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
