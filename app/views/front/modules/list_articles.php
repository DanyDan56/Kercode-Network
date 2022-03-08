<?php ob_start() ?>

<div class="container card-2 white round margin">
    <br>
    <div class="flex">
        <img src="app/public/images/examples/img_avatar2.png" alt="Photo de profil" class="circle margin-right w60">
        <h4>User One</h4>
        <span class="right opacity">1 min</span>
    </div>
    <hr>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <div class="flex">
        <div class="margin-right w50">
            <img src="app/public/images/examples/img_lights.jpg" alt="Aurore boréale" class="margin-bottom w100">
        </div>
        <div class="w50">
            <img src="app/public/images/examples/img_nature.jpg" alt="Nature" class="margin-bottom w100">
        </div>
    </div>
    <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-thumbs-up"></i>&nbsp;J'aime</button>
    <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-comment"></i>&nbsp;Commenter</button>
</div>

<?php $articlesList = ob_get_clean(); ?>