<?php ob_start() ?>

<div class="flex margin-top-medium">
    <?php for ($i = 0; $i < 15; $i++) : ?>
        <img src="app/public/images/examples/img_avatar2.png" alt="Photo test" class="w40px circle border">
    <?php endfor; ?>
</div>

<?php $friendsListHeader = ob_get_clean(); ?>