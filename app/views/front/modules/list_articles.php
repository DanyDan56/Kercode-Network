<?php ob_start() ?>

<?php foreach ($articles as $article): ?>

    <?php $articleUser = \Knetwork\Models\User::find($article->__get('user_id')); ?>

    <article class="container card-2 white round margin">
        <br>
        <div class="flex">
            <img src="app/private/images/users/<?= $articleUser->__get('id') . '/' . $articleUser->__get('profileImage'); ?>" alt="<?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="circle margin-right w60px">
            <h4><?= $articleUser->__get('firstname') . " " . $articleUser->__get('lastname'); ?></h4>
            
            <!-- On calcul le temps écoulé depuis la publication de l'article -->
            <?php $time = \Knetwork\Controllers\ArticleController::dateDiff(time(), $article->__get('created_at')); ?>
            <span class="right opacity">
                <?php
                    $str = "";
                    if ($time['day'] > 0) {
                        $str .= $time['day'] . " jour";
                        $time['day'] > 1 ? $str .= "s" : "";
                    } elseif ($time['minute'] < 1) {
                        $str = "À l'instant";
                    } else {
                        $time['hour'] > 0 ? $str .= $time['hour'] . " h " : "";
                        $time['minute'] > 0 ? $str .= $time['minute'] . " min" : "";
                    }
                    echo $str;
                ?>
            </span>
        </div>
        <hr>
        <p><?= $article->__get('content'); ?></p>
        <?php if ($article->haveImages()): ?>
            <?php $images = $article->getImages(); ?>
            <div class="flex flex-wrap flex-justify-between">
                <!-- Si une seule image -->
                <?php if (count($images) === 1): ?>
                    <div class="w100">
                        <img src="<?= $images[0] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100 btn-modal" onclick="displayImage('<?= $images[0] ?>')">
                    </div>
                <!-- Si 2 images -->
                <?php elseif (count($images) === 2): $i = 0; ?>
                    <?php foreach ($images as $image): $i++; ?>
                        <div class="w49">
                            <img src="<?= $image ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100" onclick="displayImage('<?= $image ?>')">
                        </div>
                    <?php endforeach; ?>
                <!-- Si 3 images -->
                <?php elseif (count($images) === 3): ?>
                    <div class="w67">
                        <img src="<?= $images[0]; ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100" onclick="displayImage('<?= $images[0]; ?>')">
                    </div>
                    <div class="w33">
                        <?php for($i = 1; $i < 3; $i++): ?>
                            <img src="<?= $images[$i] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100 <?= $i === 2 ? 'margin-bottom' : ''; ?>" onclick="displayImage('<?= $images[$i] ?>')">
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <div class="w100">
                        <img src="<?= $images[0] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100" onclick="displayImage('<?= $images[0] ?>')">
                    </div>
                    <?php for($i = 1; $i < count($images); $i++): ?>
                        <div class="w25">
                            <img src="<?= $images[$i] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100 margin-bottom" onclick="displayImage('<?= $images[$i] ?>')">
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-thumbs-up"></i>&nbsp;J'aime</button>
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-comment"></i>&nbsp;Commenter</button>
        <span class="float-right opacity">0 commentaire</span>
    </article>

<?php endforeach; ?>

<div id="modal-image" class="modal">
    <div class="modal-content">
        <span class="btn-modal-close">&times;</span>
    </div>
</div>

<?php $articlesList = ob_get_clean(); ?>