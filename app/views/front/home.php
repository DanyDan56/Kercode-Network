<!-- On charge les modules requis pour la page d'acceuil -->
<?php
require_once 'modules/profile_card.php';
require_once 'modules/new_article.php';
require_once 'modules/list_articles.php';
require_once 'modules/events_upcoming.php';
require_once 'modules/friends_request.php';
?>


<!-- On change le titre -->
<?php $title = 'Accueil - Kercode Network'; ?>

<?php ob_start(); ?>

<!-- Container de la page-->
<div class="container content">
    <!-- Grille perso -->
    <div class="row">
        <!-- Colonne gauche -->
        <div class="col m3">
            <!-- Module carte de profil -->
            <?= $profileCard; ?>
        </div>

        <!-- Colonne du milieu-->
        <div class="col m7">
            <!-- Module pour la création d'un nouvel article -->
            <?= $newArticle; ?>
            <!-- On affiche les articles des amis -->
            <?= $articlesList; ?>
        </div>

        <!-- Colonne droite -->
        <div class="col m2">
            <!-- Module pour les évènements à venir -->
            <?= $eventsUpcoming; ?>
            <!-- Module pour les demandes d'amis -->
            <?= $friendsRequest; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- Load the navbar & the template -->
<?php require_once 'modules/navbar.php'; ?>
<?php require_once 'templates/template.php'; ?>