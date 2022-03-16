<?php ob_start() ?>

<?php foreach ($articles as $article): ?>

    <?php $user = \Knetwork\Models\User::find($article->__get('user_id')); ?>

    <article class="container card-2 white round margin">
        <br>
        <div class="flex">
            <img src="app/public/images/examples/img_avatar2.png" alt="Photo de profil" class="circle margin-right w60">
            <h4><?= $user->__get('firstname') . " " . $user->__get('lastname'); ?></h4>
            
            <!-- On calcul le temps écoulé depuis la publication de l'article -->
            <!-- TODO: Gérer le temps - jours, heure, minutes, secondes -->
            <?php $time = \Knetwork\Controllers\ArticleController::dateDiff(time(), $article->__get('created_at')); ?>
            <span class="right opacity"><?php
                $str = "";
                if ($time['day'] > 0) {
                    $str .= $time['day'] . " jour";
                    $time['day'] > 1 ? $str .= "s" : "";
                } else {
                    $time['hour'] > 0 ? $str .= $time['hour'] . " h " : "";
                    $time['minute'] > 0 ? $str .= $time['minute'] . " min" : "";
                }
                echo $str; ?></span>
        </div>
        <hr>
        <p><?= $article->__get('content'); ?></p>
        <?php if ($article->haveImages()): ?>
            <div class="flex">
                <div class="margin-right w50">
                    <img src="app/public/images/examples/img_lights.jpg" alt="Aurore boréale" class="margin-bottom w100">
                </div>
                <div class="w50">
                    <img src="app/public/images/examples/img_nature.jpg" alt="Nature" class="margin-bottom w100">
                </div>
            </div>
        <?php endif; ?>
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-thumbs-up"></i>&nbsp;J'aime</button>
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-comment"></i>&nbsp;Commenter</button>
    </article>

<?php endforeach; ?>

<?php $articlesList = ob_get_clean(); ?>