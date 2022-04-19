<?php

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

// On démarre la session
session_start();

try {
    $adminController = new \Knetwork\Controllers\AdminController();

    // TODO: Récupérer et vérifier l'utilisateur connecté et qu'il soit bien admin

    // On vérifie si il y a une action,
    // Si oui, on la traite,
    // Sinon, on affiche dashboard
    if (isset($_GET['action'])) {

        // Affichage de la page d'administration des utilisateurs
        if ($_GET['action'] == 'users') {
            $adminController->users($_SESSION['id']);
        }
        // Affichage de la page d'administration des articles
        elseif ($_GET['action'] == 'articles') {
            $adminController->articles($_SESSION['id']);
        }
        // Affichage d'édition d'un utilisateur
        elseif ($_GET['action'] == 'useredit') {
            $adminController->editUser($_SESSION['id'], $_GET['id']);
        }
        // Mise à jour d'un utilisateur
        elseif ($_GET['action'] == 'usereditpost') {
            $data = [
                'lastname' => htmlspecialchars($_POST['lastname']),
                'firstname' => htmlspecialchars($_POST['firstname']),
                'email' => htmlspecialchars($_POST['email']),
                'gender' => $_POST['gender'],
                'birthday_date' => htmlspecialchars($_POST['birthday']),
                'address' =>  htmlspecialchars($_POST['address']),
                'job' =>  htmlspecialchars($_POST['job']),
                'admin' =>  htmlspecialchars($_POST['role'])
            ];

            $adminController->editUserPost($_SESSION['id'], $_GET['id'], $data);
        }
    } else {
        $adminController->home($_SESSION['id']);
    }
}
catch (\Exception $e) {
    include 'app/views/front/error.php';
}