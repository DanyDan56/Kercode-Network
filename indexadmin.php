<?php

use Knetwork\Controllers\AdminController;
use Knetwork\Models\User;

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

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
    // On vérifie que l'utilisateur est valide et qu'il a bien le rôle d'administrateur
    if (!User::check($_SESSION['id'], $_SESSION['password'], $_SESSION['admin'])) {
        throw new Exception("Vous n'avez pas le rôle d'administrateur", 3);
    }

    $adminController = new AdminController();

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche dashboard
    if (isset($_GET['action'])) {

        // Affichage de la page d'administration des utilisateurs
        if ($_GET['action'] == 'users') {
            $adminController->users();
        }
        // Affichage de la page d'administration des articles
        elseif ($_GET['action'] == 'articles') {
            $adminController->articles();
        }
        // Affichage de la page d'édition d'un utilisateur
        elseif ($_GET['action'] == 'useredit') {
            $adminController->editUser($_GET['id']);
        }
        // Mise à jour d'un utilisateur
        elseif ($_GET['action'] == 'usereditpost') {
            $data = [
                'lastname' => htmlspecialchars($_POST['lastname']),
                'firstname' => htmlspecialchars($_POST['firstname']),
                'email' => htmlspecialchars($_POST['email']),
                'gender' => htmlspecialchars($_POST['gender']),
                'birthday_date' => htmlspecialchars($_POST['birthday']),
                'address' =>  htmlspecialchars($_POST['address']),
                'job' =>  htmlspecialchars($_POST['job']),
                'admin' =>  htmlspecialchars($_POST['role'])
            ];

            $adminController->editUserPost($_GET['id'], $data);
        }
        // Affichage de la pge d'édition d'un article
        elseif ($_GET['action'] == 'articleedit') {
            $adminController->editArticle($_GET['id']);
        }
        // Mise à jour d'un article
        elseif ($_GET['action'] == 'articleeditpost') {
            $data = [
                'content' => htmlspecialchars($_POST['content'])
            ];

            $adminController->editArticlePost($_GET['id'], $data);
        }
    } else {
        $adminController->home();
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