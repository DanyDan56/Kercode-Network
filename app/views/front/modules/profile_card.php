<?php ob_start() ?>

<div class="card-2 round white">
    <div class="container">
        <h4 class="center">Mon profil</h4>
        <p class="center"><img src="app/public/images/examples/img_avatar2.png" alt="Photo de profil" class="circle w106 h106"></p>
        <hr>
        <p><i class="fa fa-briefcase fa-fw margin-right text-theme"></i>Développeur Web</p>
        <p><i class="fa fa-home fa-fw margin-right text-theme"></i>Vannes (56), FR</p>
        <p><i class="fa fa-birthday-cake fa-fw margin-right text-theme"></i> décembre 1983</p>
    </div>
</div>

<?php $profileCard = ob_get_clean(); ?>