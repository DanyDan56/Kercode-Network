<!-- On charge les modules requis pour la page d'aministration -->
<?php 
include_once 'modules/navbar.php';
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
                    include_once 'modules/chart.php';
                    echo $chart;
                    include_once 'modules/table_users.php';
                    echo $tableUsers;
                    break;
                case 'useredit':
                    include_once 'modules/user_details.php';
                    echo $userDetails;
                    break;
                case 'usereditpost':
                    include_once 'modules/user_details.php';
                    echo $userDetails;
                    break;
                case 'articles':
                    include_once 'modules/chart.php';
                    echo $chart;
                    include_once 'modules/table_articles.php';
                    echo $tableArticles;
                    break;
                case 'articleedit':
                    include_once 'modules/article_details.php';
                    echo $articleDetails;
                    break;
                case 'articleeditpost':
                    include_once 'modules/article_details.php';
                    echo $articleDetails;
                    break;
                case 'comments':
                    include_once 'modules/chart.php';
                    echo $chart;
                    include_once 'modules/table_comments.php';
                    echo $tableComments;
                    break;
                case 'commentedit':
                    include_once 'modules/comment_details.php';
                    echo $commentDetails;
                    break;
                case 'commenteditpost':
                    include_once 'modules/comment_details.php';
                    echo $commentDetails;
                    break;
                default:
                    include_once 'modules/dashboard.php';
                    echo $dashboard;
            }; ?>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- On récupère la navbar & the template -->
<?php /* require './app/views/front/modules/navbar.php'; */ ?>
<?php require './app/views/front/templates/template.php'; ?>