<?php 
include_once 'friends_list_header.php';
ob_start();
?>
<div class="card-2 white">
    <div id="profile-header">
        <img class="profile-cover" src="app/public/images/examples/img_forest.jpg"
            alt="Image de couverture de <?= $user->getNames(); ?>">
        
    </div>

    <div class="flex flex-wrap padding-bottom">
        <img class=" profile-image circle border" src="<?= $user->getProfileImage(); ?>" alt="Image de profil de <?= $user->getNames(); ?>">
        <div id="profile-infos">
            <h1><?= $user->__get('firstname'); ?> <?= $user->__get('lastname'); ?></h1>
            <p class="font-large no-margin">191 amis</p>
            <?= $friendsListHeader; ?>
        </div>
    </div>
</div>

<?php $profileHeader = ob_get_clean(); ?>