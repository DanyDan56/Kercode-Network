<?php

use Knetwork\Models\User;

// On charge les packages nécessaires fourni par Composer
require_once __DIR__ . '/vendor/autoload.php';

/* TODO:
- Responsive Design
- Remplacer les onclic par des eventListener
*/

// On démarre la session
session_start();

// gc_disable();
// var_dump(gc_status());

try {
    // On récupère les controllers
    $frontController = new \Knetwork\Controllers\FrontController();
    $userController = new \Knetwork\Controllers\UserController();
    $articleController = new \Knetwork\Controllers\ArticleController();

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
            unset($_SESSION['id']);
            session_destroy();
            header('location: index.php');
        }

        //*************************** GESTION DES ARTICLES **********************************/

        // Nouvel article
        else if ($_GET['action'] == 'newarticle') {
            // Si il y a aucun contenu, on redirige vers l'index
            if ($_POST['new-article-edit'] != "" || $_FILES['image-article']['size'][0] != 0) {
                $content = htmlspecialchars($_POST['new-article-edit']);
                $articleController->addArticle($content, $_FILES['image-article']);
            } else {
                new \Exception("Erreur lors de la création de l'article", 3);
            }
        }
        // Modification d'article
        else if ($_GET['action'] == 'modifyarticle') {
            $content = htmlspecialchars($_POST['article-edit-' . $_GET['id']]);
            $articleController->modifyArticle($_GET['id'], $content);
        }
        // Suppression d'article
        else if ($_GET['action'] == 'deletearticle') {
            $articleController->deleteArticle($_GET['id']);
        }

        //*************************** GESTION DU PROFIL **********************************/
        
        // Affichage de la page de profil
        else if ($_GET['action'] == 'profile') {
            $frontController->profile($_SESSION['id']);
        }

    } else {
        // On check si l'utilisateur est connecté
        // Si oui, on affiche la page accueil correspondante au rôle
        // Si non, on affiche la pge de login
        if (isset($_SESSION['id'])) {
            // var_dump(User::getInstance());die;
            $frontController->home($_SESSION['id']);
            // TODO: rediriger si admin
        } else {
            $frontController->login();
        }
    }
} catch (\Exception $e) {
    include 'app/views/front/error.php';
}
