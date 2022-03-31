<!-- On charge les modules requis pour la page de profil -->
<?php
include 'modules/profile_header.php';
?>

<!-- On change le titre -->
<?php $title = $user->__get('firstname') . ' ' . $user->__get('lastname') . ' - Kercode Network'; ?>

<?php ob_start(); ?>

<!-- Container de la page-->
<div class="container content">
    <!-- Grille perso -->
    <div class="row">
        <div class="col m12">
            <?= $profileHeader; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- On récupère la navbar & le template -->
<?php require 'modules/navbar.php'; ?>
<?php require 'templates/template.php'; ?>