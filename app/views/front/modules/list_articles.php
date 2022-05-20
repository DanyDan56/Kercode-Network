<?php

 ob_start() ?>

<?php foreach ($articles as $article): ?>

    <?php $articleUser = \Knetwork\Models\User::find($article->__get('user_id')); ?>

    <article class="container card-2 white round padding-top margin-bottom">
        <div class="flex">
            <!-- Photo du profil -->
            <a href="index.php?action=profile&id=<?= $articleUser->__get('id'); ?>"><img src="<?= $articleUser->getProfileImage(); ?>" alt="<?= $articleUser->getNames(); ?>" class="circle margin-right w60px"></a>
            
            <div>
                <!-- Nom et prénom du profil -->
                <h4 class="no-margin"><a class="no-decoration hover-underline" href="index.php?action=profile&id=<?= $articleUser->__get('id'); ?>"><?= $articleUser->getNames(); ?></a></h4>
                
                <span class="opacity">
                    <!-- TODO: Mettre dans un helper -->
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
                <div class="article-options circle center right top" data-id="<?= $article->__get('id'); ?>">
                    <span class="text-gray bold space-letters">...</span>
                    <div id="menu-article-<?= $article->__get('id'); ?>" class="dropdown-content dropdown-content-right white card-4 hide">
                        <a class="hover-gray" title="Modifier le contenu du post">Modifier</a>
                        <a href="index.php?action=deletearticle&id=<?= $article->__get('id'); ?>" class="text-red hover-red" title="Supprimer le post">Supprimer</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <hr>
        
        <!-- Texte -->
        <p id="article-<?= $article->__get('id'); ?>"><?= $article->__get('content'); ?></p>

        <!-- Texte édition -->
        <form action="index.php?action=modifyarticle&id=<?= $article->__get('id'); ?>" method="POST">
            <textarea name="article-edit-<?= $article->__get('id'); ?>" id="article-edit-<?= $article->__get('id'); ?>" rows="4" class="w100 hide" style="resize: none"></textarea>
            <div id="buttons-article-edit-<?= $article->__get('id'); ?>" class="flex hide">
                <button type="submit" class="btn btn-block green margin-bottom-small" title="Publier"><i class="fa fa-check"></i></button>
                <button class="btn btn-block red margin-bottom-small" title="Annuler"><i class="fa fa-remove"></i></button>
            </div>
        </form>

        <!-- Images -->
        <!-- Disposition différente en fonction du nombre d'images -->
        <?php if ($article->havePictures()): ?>
            <?php $images = $article->getPictures(); ?>
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
        <button type="button" class="btn btn-like theme-d1 margin-bottom" data-articleid="<?= $article->__get('id'); ?>"><i class="fa fa-thumbs-up"></i>&nbsp;J'aime</button>
        <button type="button" class="btn btn-comment theme-d1 margin-bottom" data-articleid="<?= $article->__get('id'); ?>"><i class="fa fa-comment"></i>&nbsp;Commenter</button>
        
        <!-- Infos d'intéractions -->
        <?php $comments = $article->getComments(); ?>
        <span class="float-right opacity"><?= count($comments); ?> commentaire<?= (count($comments) > 1) ? 's' : ''; ?></span>

        <hr class="no-margin">

        <!-- Commentaires -->
        <?php if (count($comments) > 2) : ?>
            <div class="show-comments pointer hover-underline bold" data-articleid="<?= $article->__get('id'); ?>">
                <p class="no-events">Voir les commentaires précédents</p>
            </div>
        <?php endif; ?>

        <!-- Commentaires -->
        <?php
        if ($comments) :
            for ($i = 0; $i < count($comments); $i++) :
                $commentUser = $comments[$i]->getUser();?>
                <div class="comments comment-<?= $article->__get('id'); ?> <?= ($i < count($comments) - 2) ? 'hide' : 'flex' ?>" data-commentid="<?= $comments[$i]->__get('id'); ?>">
                    <p class="no-margin"><a href="index.php?action=profile&id=<?= $commentUser->__get('id'); ?>"><img src="<?= $commentUser->getProfileImage(); ?>" alt="Photo de profil de <?= $commentUser->getNames(); ?>" class="w40px margin-right-small circle hfit"></a></p>
                    <div class="theme-l4 comments-content w100 padding margin-bottom round">
                        <div class="flex flex-justify-between">
                            <p class="no-margin"><a class="bold no-decoration hover-underline" href="index.php?action=profile&id=<?= $commentUser->__get('id'); ?>"><?= $commentUser->getNames(); ?></a></p>
                            <div class="flex">
                                <!-- TODO: Mettre dans un helper -->
                                <!-- Temps écoulé -->
                                <p class="no-margin opacity font-small">
                                    <?php $time = \Knetwork\Controllers\ArticleController::dateDiff(time(), $comments[$i]->__get('created_at')); ?>
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
                                </p>
                                
                                <!-- Actions -->
                                <div id="comment-actions-<?= $comments[$i]->__get('id') ?>" class="comment-actions flex hide">
                                    <?php if ($commentUser->__get('id') === $_SESSION['id']): ?>
                                        <a id="comment-action-edit-<?= $comments[$i]->__get('id') ?>" class="font-small no-margin margin-left margin-right-small pointer" title="Modifier le commentaire"><i class="fa fa-pen text-green"></i></a>
                                        <a href="index.php?action=deletecomment&id=<?= $comments[$i]->__get('id'); ?>" class="font-small no-margin pointer" title="Supprimer le commentaire"><i class="fa fa-trash text-red"></i></a>
                                    <?php else: ?>
                                        <a class="font-small no-margin margin-left margin-right-small pointer" title="Signaler le commentaire"><i class="fa fa-ban text-red"></i></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Contenu du commentaire -->
                        <p id="comment-content-<?= $comments[$i]->__get('id'); ?>" class="no-margin"><?= $comments[$i]->__get('content'); ?></p>

                        <!-- Commentaire édition -->
                        <form id="comment-edit-<?= $comments[$i]->__get('id'); ?>" action="index.php?action=modifycomment&id=<?= $comments[$i]->__get('id'); ?>" method="POST" class="hide">
                            <textarea name="comment-edit-<?= $comments[$i]->__get('id'); ?>" rows="2" class="w100 round" style="resize: none"></textarea>
                        </form>
                    </div>
                </div>
        <?php endfor; endif; ?>
        
        <!-- Edition d'un nouveau commentaire -->
        <form id="form-comment-<?= $article->__get('id'); ?>" class="flex" action="index.php?action=newcomment&idarticle=<?= $article->__get('id'); ?>" method="POST">
            <a href="index.php?action=profile"><img src="<?= $user->getProfileImage(); ?>" alt="Photo de profil de <?= $user->getNames(); ?>" class="w40px margin-right-small circle hfit"></a>
            <textarea name="new-comment-edit" id="new-comment-edit-<?= $article->__get('id'); ?>" rows='1' class="comment-edit w100 no-resize margin-bottom round" placeholder="Ecrivez un commentaire..." data-articleid="<?= $article->__get('id'); ?>"></textarea>
        </form>
    </article>

<?php endforeach; ?>

<div id="modal-image" class="modal">
    <!-- <div class="modal-content">
        <span class="btn-modal-close">&times;</span>
    </div> -->
</div>

<?php $articlesList = ob_get_clean(); ?>