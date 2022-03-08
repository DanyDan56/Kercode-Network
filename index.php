<?php

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

session_start();

try {
    // on récupère les controllers
    $frontController = new \Knetwork\Controllers\FrontController();
    $userController = new \Knetwork\Controllers\UserController();

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche soit la page login ou home en fonction si il y a une session d'ouverte ou pas
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'register') {
            $frontController->register();
        }
        else if ($_GET['action'] == 'loginpost') {
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $userController->login($email, $password);
        }
        else if ($_GET['action'] == 'disconnect') {
            session_destroy();
            header('location: index.php');
        }
    } else {
        // On check si la session est setup
        if (isset($_SESSION['id'])) {
            // TODO: rediriger si admin
            $frontController->home();
        } else {
            $frontController->login();
        }
    }
} catch (\Exception $e) {
    require 'app/views/front/error.php';
}
