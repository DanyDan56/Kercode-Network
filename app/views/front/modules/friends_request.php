<?php ob_start(); ?>

<aside class="card-2 round white center margin-top-small">
    <div class="container">
        <p>Demande en amis (WIP)</p>
        <img src="app/public/images/examples/img_avatar6.png" alt="Photo de profil" class="w50">
        <br>
        <span>User Three</span>
        <div class="flex opacity">
            <button class="section btn btn-block green" title="Accepter"><i class="fa fa-check"></i></button>
            <button class="section btn btn-block red" title="Refuser"><i class="fa fa-remove"></i></button>
        </div>
    </div>
</aside>

<?php $friendsRequest = ob_get_clean(); ?>