<!-- On charge les modules requis pour la page d'aministration -->
<?php 
include_once 'modules/navbar.php';
include_once 'modules/dashboard.php';
?>

<!-- On change le titre -->
<?php $title = 'Dashboard - Kercode Network'; ?>

<?php ob_start(); ?>

<div class="container-full">
    <div class="flex">
        <!-- Menu -->
        <div>
            <?= $navbarAdmin ?>
        </div>

        <div class="col m12">
            <!-- On affiche le module en fonction de la page -->
            <?php
            switch ($page) {
                case 'users':
                    echo $dashboard;
                    include_once 'modules/table_users.php';
                    echo $tableUsers;
                    break;
                case 'articles':
                    echo $dashboard;
                    include_once 'modules/table_articles.php';
                    echo $tableArticles;
                    break;
                case 'useredit':
                    include_once 'modules/user_details.php';
                    echo $userDetails;
                    break;
                case 'usereditpost':
                    include_once 'modules/user_details.php';
                    echo $userDetails;
                    break;
                default:
                    echo $dashboard;
                    include_once 'modules/charts.php';
                    echo $charts;
            }; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- On récupère la navbar & the template -->
<?php /* require './app/views/front/modules/navbar.php'; */ ?>
<?php require './app/views/front/templates/template.php'; ?>