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
        <div class="hide-small col m3 margin-top-large">
            <?php
            // Si on est sur la page de profil d'une autre personne
            if (isset($_GET['id'])) {
                include 'modules/profile_card.php';
                echo $profileCard;
            }
            // Sinon, c'est qu'on est sur notre propre page de profil
            else {
                echo $eventsUpcoming;
                echo $friendsRequest;
            } ?>
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