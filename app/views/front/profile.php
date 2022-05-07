<!-- On charge les modules requis pour la page de profil -->
<?php
include 'modules/profile_header.php';
include 'modules/list_articles.php';
include 'modules/events_upcoming.php';
include 'modules/friends_request.php';
?>

<!-- On change le titre -->
<?php $title = $user->getNames() . ' - Kercode Network'; ?>

<?php ob_start(); ?>

<!-- Container de la page-->
<div class="container content">
    <!-- Grille perso -->
    <header class="col m12">
        <?= $profileHeader; ?>
        <hr>
    </header>
    <div class="flex">
        <div class="col m3 margin-top-large">
            <?= $eventsUpcoming; ?>
            <?= $friendsRequest; ?>
        </div>
        <div class="col m9 margin margin-top-large">
            <?= $articlesList; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- On récupère la navbar & le template -->
<?php require 'modules/navbar.php'; ?>
<?php require 'templates/template.php'; ?>