<?php

// On charge les packages nécessaires fourni par Composer

use Knetwork\Models\User;

require_once __DIR__ . '/vendor/autoload.php';

// On démarre la session
session_start();

try {
    // On récupère les controllers
    $frontController = new \Knetwork\Controllers\FrontController();
    $userController = new \Knetwork\Controllers\UserController();
    $articleController = new \Knetwork\Controllers\ArticleController();

    $user = null;

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche soit la page login ou home en fonction si il y a une session de setup ou pas
    if (isset($_GET['action'])) {
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
        // Traitement de la connexion à un compte
        else if ($_GET['action'] == 'loginpost') {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $user = $userController->login($email, $password);
        }
        // Déconnexion
        else if ($_GET['action'] == 'disconnect') {
            session_destroy();
            header('location: index.php');
        }
        // Nouvel article
        else if ($_GET['action'] == 'newarticle') {
            $content = htmlspecialchars($_POST['new-article-edit']);
            $articleController->addArticle($content);
        }
    } else {
        // On check si l'utilisateur est connecté
        // Si oui, on affiche la page accueil correspondante au rôle
        // Si non, on affiche la pge de login
        if (isset($_SESSION['id'])) {
            $frontController->home($_SESSION['id']);
            // TODO: rediriger si admin
        } else {
            $frontController->login();
        }
    }
} catch (\Exception $e) {
    require 'app/views/front/error.php';
}
