<?php

// Si il y a aucune session, on en créé une
if (!isset($_SESSION)) {
    session_start();
}

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

try {
    // on récupère le controller pour le frontend
    $frontController = new \Knetwork\Controllers\FrontController();

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche soit la page login ou home en fonction si il y a une session d'ouverte ou pas
    if (isset($_GET['action'])) {
        if($_GET['action'] == 'register') {
            $frontController->register();
        }
    } else {
        // On check si la session a bien été setup
        if (isset($_SESSION['lastname'])) {
            // TODO: rediriger si admin
            $frontController->home();
        } else {
            $frontController->login();
        }
    }
} catch (\Exception $e) {
    require 'app/views/front/error.php';
}