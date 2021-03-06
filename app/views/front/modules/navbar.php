<?php ob_start(); ?>

<nav class="fixed-top">
    <ul class="navbar theme-d2 font-xlarge">
        <!-- Navbar for tablet & desktop display -->
        <li class="hide-small">
            <?php if ($user->isAdmin()): ?>
                <a href="indexadmin.php" class="theme-d4 padding-large">
                    <i class="fa fa-chart-column margin-right"></i>Administration
                </a>
            <?php else: ?>
                <a href="index.php" class="theme-d4 padding-large">
                    <i class="fa fa-home margin-right"></i>Kercode Network
                </a>
            <?php endif; ?>
        </li>
        <li class="">
            <a href="index.php" class="padding-large hover-white" title="Actualités">
                <i class="fa fa-globe"></i>
            </a>
        </li>
        <li class="">
            <a href="#" class="padding-large hover-white" title="Amis (WIP)">
                <i class="fa fa-user"></i>
            </a>
        </li>
        <li class="">
            <a href="#" class="padding-large hover-white" title="Messages (WIP)">
                <i class="fa fa-envelope"></i>
            </a>
        </li>
        <li class="dropdown-hover">
            <a href="#" class="padding-large hover-white" title="Notifications (WIP)">
                <i class="fa fa-bell"></i>
                <span class="badge float-right font-small green">3</span>
            </a>
            <div class="dropdown-content dropdown-anim white card-4">
                <a href="#">1 nouvelle requête d'ami</a>
                <a href="#">Jean Dupont a posté sur votre mur</a>
                <a href="#">Daniel aime votre publication</a>
            </div>
        </li>
        <li class="right dropdown-hover">
            <a href="#" class="image-profile hover-white" title="Mon compte">
                <img src="<?= $user->getProfileImage(); ?>" alt="<?= $user->getNames(); ?>" class="circle fill">
            </a>
            <div class="dropdown-content dropdown-content-right dropdown-anim white card-4">
                <?php if ($user->isAdmin()): ?>
                    <a href="indexadmin.php" class="text-blue hover-blue">Administration</a>
                <?php endif; ?>
                <a href="index.php?action=profile">Mon profil</a>
                <a href="#">Paramètres</a>
                <a href="index.php?action=disconnect" class="text-red hover-red">Se déconnecter</a>
            </div>
        </li>

        <!-- Burger for mobile display -->
        <!-- <li class="hide-medium hide-large right">
            <a href="#" class="padding-large hover-white">
                <i class="fa fa-bars"></i>
            </a>
        </li> -->
    </ul>
</nav>

<?php $navbar = ob_get_clean(); ?>