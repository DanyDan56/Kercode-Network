<!-- On charge les modules requis pour la page d'acceuil -->
<?php
include 'modules/profile_card.php';
include 'modules/new_article.php';
include 'modules/list_articles.php';
include 'modules/events_upcoming.php';
include 'modules/friends_request.php';
?>


<!-- On change le titre -->
<?php $title = 'Accueil - Kercode Network'; ?>

<?php ob_start(); ?>

<!-- Container de la page-->
<div class="container content">
    <!-- Grille perso -->
    <div class="flex">
        <!-- Colonne gauche -->
        <div class="hide-small col l3 m4 margin-top-large">
            <!-- Module carte de profil -->
            <?= $profileCard; ?>

            <!-- On affiche seulement au format medium -->
            <div class="hide-large show-medium margin-top-medium">
                <!-- Module pour les évènements à venir -->
                <?= $eventsUpcoming; ?>
                <!-- Module pour les demandes d'amis -->
                <?= $friendsRequest; ?>
            </div>
        </div>

        <!-- Colonne du milieu-->
        <div class="col l7 m8 margin-top-large">
            <!-- Module pour la création d'un nouvel article -->
            <?= $newArticle; ?>
            <div class="margin">
            <!-- On affiche les articles des amis -->
            <?= $articlesList; ?></div>
        </div>

        <!-- Colonne droite -->
        <div class="hide-small hide-medium col l2 margin-top-large">
            <!-- Module pour les évènements à venir -->
            <?= $eventsUpcoming; ?>
            <!-- Module pour les demandes d'amis -->
            <?= $friendsRequest; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- On récupère la navbar & the template -->
<?php require 'modules/navbar.php'; ?>
<?php require 'templates/template.php'; ?>