<?php ob_start(); ?>

<aside class="card-2 round white">
    <div class="container">
        <!-- Header -->
        <p class="center"><img src="app/private/images/users/<?= $user->__get('id') . "/" . $user->__get('profileImage'); ?>" alt="<?= $user->__get('firstname') . " " . $user->__get('lastname'); ?>" class="circle w106 h106"></p>
        <p class="center"><a href="#" class="no-decoration font-xlarge"><?= $user->__get('firstname') . " " . $user->__get('lastname'); ?></a></p>
        <hr>
        <!-- Infos -->
        <p><i class="fa fa-briefcase fa-fw margin-right text-theme"></i><?= $user->__get('job'); ?></p>
        <p><i class="fa fa-home fa-fw margin-right text-theme"></i><?= $user->__get('address'); ?>, FR</p>
        <p><i class="fa fa-birthday-cake fa-fw margin-right text-theme"></i><?= $user->__get('birthdayDate'); ?></p>
    </div>
</aside>

<?php $profileCard = ob_get_clean(); ?>