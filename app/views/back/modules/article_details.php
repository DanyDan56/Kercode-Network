<?php ob_start(); ?>

<div class="admin-content">
    <form action="indexadmin.php?action=articleeditpost&id=<?= $article->__get('id'); ?>" id="article-edit" method="POST">
        <div class="flex flex-wrap">
            <h1>
                <a href="indexadmin.php?action=articles"><i class="fa fa-arrow-left"></i></a>
                Edition d'article (<?= $article->__get('id'); ?>)
            </h1>
            <a href="indexadmin.php?action=articledelete&id=<?= $article->__get('id'); ?>" class="btn red right h40px bottom">Supprimer</a>
            <button type="submit" class="btn green h40px bottom margin-left">Enregistrer</button>
        </div>
        <hr>
    
        <!-- Header -->
        <!-- On gère les exceptions -->
        <?php try {
            if(isset($e)) { throw $e; }
        } catch(\Exception $e) { ?>
            <?php if($e->getCode() === 0): ?>
                <div id="info-box-admin" class="info-box margin-bottom"><p><?= $e->getMessage(); ?></p></div>
            <?php elseif($e->getCode() === 3): ?>
                <div class="alert-box margin-bottom"><p><?= $e->getMessage(); ?></p></div>
            <?php endif; ?>
        <?php } ?>

        <!-- Informations -->
        <div class="theme-l3 flex">
            <p class="bold margin">
                Publié par <a href="indexadmin.php?action=useredit&id=<?= $articleUser->__get('id'); ?>"><?= $articleUser->__get('firstname') . ' ' . $articleUser->__get('lastname'); ?></a><br>
                Créé le <?= \Knetwork\Helpers\Helper::dateToFrench($article->__get('created_at'), "d F Y H:i:s"); ?><br>
                Mise à jour le <?= \Knetwork\Helpers\Helper::dateToFrench($article->__get('updated_at'), "d F Y H:i:s"); ?>
            </p>
        </div>

        <!-- Texte -->
        <textarea name="content" id="content" class="w100 margin-top no-resize"><?= $article->__get('content'); ?></textarea>

        <!-- Images -->
        <?php if ($article->havePictures()): ?>
            <?php $images = $article->getPictures(); ?>
            <div class="flex margin-top">
                <?php foreach ($images as $image): ?>
                    <img src="<?= $image; ?>" alt="Photo de <?= $articleUser->__get('firstname'); ?> <?= $articleUser->__get('lastname'); ?>" class="w20 pointer modalable" data-path='<?= $image ?>'>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </form>

    <!-- Infos serveur et base de données -->
    <div class="theme-l4">
        <p class="margin">
            Poids des images uploadées sur le serveur: 
            <?php if ($article->havePictures()): ?>
                <strong><?= \Knetwork\Helpers\Helper::formatSize($article->getDirPath()); ?></strong><br>
            <?php else: ?>
                <strong>0 Ko</strong><br>
            <?php endif; ?>
            Nombre de commentaires: <strong><?= $article->countComments(); ?></strong><br>
            Nombre de likes: <strong>A venir</strong>
        </p>
    </div>
</div>

<div id="modal-image" class="modal">
    <!-- <div class="modal-content">
        <span class="btn-modal-close">&times;</span>
    </div> -->
</div>

<?php $articleDetails = ob_get_clean(); ?>