<?php ob_start(); ?>

<?php $page = $_GET['action'] ?? 'dashboard'; ?>

<nav class="">
    <ul class="navbar navbar-admin theme-d2 font-large">
        <li>
            <a href="index.php" class="theme-d4 padding-large">
                <i class="fa fa-home margin-right"></i>Kercode Network
            </a>
        </li>
        <li class="navbar-item margin-top-medium">
            <span><i class="fa fa-magnifying-glass icon-input"></i></span>
            <input type="search" placeholder="Rechercher">
        </li>
        <hr>
        <li class="navbar-item margin-bottom <?= $page == 'dashboard' ? 'selected' : '' ?>">
            <a href="indexadmin.php" class="padding-large center">
                <i class="fa fa-chart-column margin-right"></i>Dashboard
            </a>
        </li>
        <li class="navbar-item navbar-subitem font-medium <?= $page == 'users' || $page == 'useredit' || $page == 'usereditpost' ? 'selected' : '' ?>">
            <a href="indexadmin.php?action=users" class="padding-large">
                <i class="fa fa-users margin-right"></i>Utilisateurs
            </a>
        </li>
        <li class="navbar-item navbar-subitem font-medium <?= $page == 'articles' || $page == 'articleedit' || $page == 'articleeditpost' ? 'selected' : '' ?>">
            <a href="indexadmin.php?action=articles" class="padding-large">
                <i class="fa fa-newspaper margin-right"></i>Articles
            </a>
        </li>
        <li class="navbar-item navbar-subitem font-medium <?= $page == 'comments' ? 'selected' : '' ?>">
            <a href="indexadmin.php?action=comments" class="padding-large">
                <i class="fa fa-comments margin-right"></i>Commentaires
            </a>
        </li>
        <li class="navbar-item navbar-subitem font-medium <?= $page == 'pictures' ? 'selected' : '' ?>">
            <a href="indexadmin.php?action=pictures" class="padding-large">
                <i class="fa fa-image margin-right"></i>Photos
            </a>
        </li>
        <li class="navbar-item bottom">
            <div class="margin-right-small"><img src="./app/private/images/users/<?= $user->__get('id'); ?>/<?= $user->__get('profileImage'); ?>" alt="Profil" class="w25px circle float-left"></div>
            <p class="no-margin"><?= $user->__get('firstname'); ?></p>
            <a href="index.php?action=disconnect" class="font-small right" style="width:min-content"><i class="fa fa-right-from-bracket float-right"></i></a>
        </li>
    </ul>
    <div class="btn navbar-admin-burger hide-large"><i class="fa fa-bars"></i></div>
</nav>

<?php $navbarAdmin = ob_get_clean(); ?>