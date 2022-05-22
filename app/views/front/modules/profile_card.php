<?php ob_start(); ?>

<aside class="card-2 round white">
    <div class="container">
        <!-- Header -->
        <!-- Si on est sur une page de profil -->
        <?php if (isset($_GET['action']) && $_GET['action'] == "profile"): ?>
            <p class="center bold">Informations</p>
        <?php else: ?>
            <p class="center"><img src="<?= $user->getProfileImage(); ?>" alt="<?= $user->getNames(); ?>" class="circle w106 h106"></p>
            <p class="center"><a href="index.php?action=profile&id=<?= $user->__get('id'); ?>" class="no-decoration hover-underline font-xlarge"><?= $user->getNames(); ?></a></p>
        <?php endif; ?>
        <hr>
        <!-- Infos -->
        <p><i class="fa fa-briefcase fa-fw margin-right text-theme"></i><?= $user->__get('job'); ?></p>
        <p><i class="fa fa-home fa-fw margin-right text-theme"></i><?= $user->__get('address'); ?>, FR</p>
        <p><i class="fa fa-birthday-cake fa-fw margin-right text-theme"></i><?= \Knetwork\Helpers\Helper::dateToFrench($user->__get('birthdayDate')); ?></p>
    </div>
</aside>

<?php $profileCard = ob_get_clean(); ?>
