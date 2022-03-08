<?php ob_start(); ?>

<div class="card-2 round white center">
    <div class="container margin">
        <p>Demande en amis</p>
        <img src="app/public/images/examples/img_avatar6.png" alt="Photo de profil" class="w50">
        <br>
        <span>User Three</span>
        <div class="flex opacity">
            <button class="btn btn-block green section" title="Accepter"><i class="fa fa-check"></i></button>
            <button class="btn btn-block red section" title="Refuser"><i class="fa fa-remove"></i></button>
        </div>
    </div>
</div>

<?php $friendsRequest = ob_get_clean(); ?>