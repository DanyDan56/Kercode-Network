<!-- On change le titre -->
<?php $title = 'Erreur - Kercode Network'; ?>

<?php ob_start(); ?>

<div class="alert-box margin-bottom"><p><?= $e->getMessage(); ?></p></div>

<?php $content = ob_get_clean(); ?>

<?php require 'templates/template.php'; ?>