<?php ob_start(); ?>

<aside class="card-2 round white center">
    <div class="container">
        <p>Evènements à venir (WIP)</p>
        <img src="app/public/images/examples/img_forest.jpg" alt="Forêt" class="w100">
        <p><strong>Vacances</strong></p>
        <p>Vendredi 16:30</p>
        <p><button type="button" class="btn btn-block theme-l4">Info</button></p>
    </div>
</aside>

<?php $eventsUpcoming = ob_get_clean(); ?>