<?php ob_start() ?>

<?php foreach ($articles as $article): ?>

    <?php $articleUser = \Knetwork\Models\User::find($article->__get('user_id')); ?>

    <article class="container card-2 white round margin">
        <br>
        <div class="flex">
            <!-- Photo du profil -->
            <img src="app/private/images/users/<?= $articleUser->__get('id') . '/' . $articleUser->__get('profileImage'); ?>" alt="<?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="circle margin-right w60px">
            
            <div>
                <!-- Nom et prénom du profil -->
                <h4 class="no-margin"><?= $articleUser->__get('firstname') . " " . $articleUser->__get('lastname'); ?></h4>
                
                <span class="opacity">
                    <!-- On calcul le temps écoulé depuis la publication de l'article -->
                    <?php $time = \Knetwork\Controllers\ArticleController::dateDiff(time(), $article->__get('created_at')); ?>
                        <?php
                            $str = "";
                            if ($time['day'] > 0) {
                                $str .= $time['day'] . " jour";
                                $time['day'] > 1 ? $str .= "s" : "";
                            } elseif ($time['minute'] < 1 && $time['hour'] < 1 && $time['day'] < 1) {
                                $str = "À l'instant";
                            } else {
                                $time['hour'] > 0 ? $str .= $time['hour'] . " h " : "";
                                $time['minute'] > 0 ? $str .= $time['minute'] . " min" : "";
                            }
                            echo $str;
                        ?>
                </span>
            </div>

            <!-- Menu d'édition et de suppression -->
            <!-- On affiche seulement le menu si l'article appartient à l'utlisateur -->
            <?php if ($article->__get('user_id') === $_SESSION['id']): ?>
                <div class="article-options circle pointer center right top" data-id="<?= $article->__get('id'); ?>">
                    <span class="text-gray bold space-letters">...</span>
                    <div id="menu-article-<?= $article->__get('id'); ?>" class="dropdown-content dropdown-content-right white card-4 hide">
                        <a class="hover-gray">Modifier</a>
                        <a href="index.php?action=deletearticle&id=<?= $article->__get('id'); ?>" class="text-red hover-red">Supprimer</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <hr>
        
        <!-- Texte -->
        <p id="article-<?= $article->__get('id'); ?>"><?= $article->__get('content'); ?></p>

        <!-- Texte édition -->
        <form action="index.php?action=modifyarticle&id=<?= $article->__get('id'); ?>" method="POST">
            <textarea name="article-edit-<?= $article->__get('id'); ?>" id="article-edit-<?= $article->__get('id'); ?>" rows="4" class="w100 hide" style="resize: none" placeholder="Exprimez-vous !"></textarea>
            <div id="buttons-article-edit-<?= $article->__get('id'); ?>" class="flex hide">
                <button type="submit" class="btn btn-block green margin-bottom-small" title="Publier"><i class="fa fa-check"></i></button>
                <button class="btn btn-block red margin-bottom-small" title="Annuler"><i class="fa fa-remove"></i></button>
            </div>
        </form>

        <!-- Images -->
        <!-- Disposition différente en fonction du nombre d'images -->
        <?php if ($article->haveImages()): ?>
            <?php $images = $article->getImages(); ?>
            <div class="flex flex-wrap flex-justify-between">
                <!-- Si une seule image -->
                <?php if (count($images) === 1): ?>
                    <div class="w100">
                        <img src="<?= $images[0] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100 modalable" data-path='<?= $images[0] ?>'>
                    </div>
                <!-- Si 2 images -->
                <?php elseif (count($images) === 2): $i = 0; ?>
                    <?php foreach ($images as $image): $i++; ?>
                        <div class="w49">
                            <img src="<?= $image ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100 modalable" data-path='<?= $image ?>'>
                        </div>
                    <?php endforeach; ?>
                <!-- Si 3 images -->
                <?php elseif (count($images) === 3): ?>
                    <div class="w67">
                        <img src="<?= $images[0]; ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer margin-bottom w100 modalable" data-path='<?= $images[0]; ?>'>
                    </div>
                    <div class="w33">
                        <?php for($i = 1; $i < 3; $i++): ?>
                            <img src="<?= $images[$i] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100 modalable <?= $i === 2 ? 'margin-bottom' : ''; ?>" data-path='<?= $images[$i] ?>'>
                        <?php endfor; ?>
                    </div>
                <?php else: ?>
                    <div class="w100">
                        <img src="<?= $images[0] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100 modalable" data-path='<?= $images[0] ?>'>
                    </div>
                    <?php for($i = 1; $i < count($images); $i++): ?>
                        <div class="w25">
                            <img src="<?= $images[$i] ?>" alt="Photo de <?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?>" class="pointer w100 margin-bottom modalable" data-path='<?= $images[$i] ?>'>
                        </div>
                    <?php endfor; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Boutons d'intéractions -->
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-thumbs-up"></i>&nbsp;J'aime</button>
        <button type="button" class="btn theme-d1 margin-bottom"><i class="fa fa-comment"></i>&nbsp;Commenter</button>
        
        <!-- Infos d'intéractions -->
        <span class="float-right opacity">0 commentaire</span>
    </article>

<?php endforeach; ?>

<div id="modal-image" class="modal">
    <!-- <div class="modal-content">
        <span class="btn-modal-close">&times;</span>
    </div> -->
</div>

<?php $articlesList = ob_get_clean(); ?>