<?php ob_start(); ?>

<div class="admin-content">
    <form action="indexadmin.php?action=commenteditpost&id=<?= $comment->__get('id'); ?>" id="comment-edit" method="POST">
        <div class="flex flex-wrap">
            <h1>
                <a href="indexadmin.php?action=comments"><i class="fa fa-arrow-left"></i></a>
                Edition d'article (<?= $comment->__get('id'); ?>)
            </h1>
            <a href="indexadmin.php?action=commentdelete&id=<?= $comment->__get('id'); ?>" class="btn red right h40px bottom">Supprimer</a>
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
                Publié par <a href="indexadmin.php?action=useredit&id=<?= $commentUser->__get('id'); ?>"><?= $commentUser->getNames(); ?></a><br>
                Créé le <?= \Knetwork\Helpers\Helper::dateToFrench($comment->__get('created_at'), "d F Y H:i:s"); ?><br>
                Mise à jour le <?= \Knetwork\Helpers\Helper::dateToFrench($comment->__get('updated_at'), "d F Y H:i:s"); ?>
            </p>
        </div>

        <!-- Texte -->
        <textarea name="content" id="content" class="w100 margin-top no-resize"><?= $comment->__get('content'); ?></textarea>
    </form>
</div>

<?php $commentDetails = ob_get_clean(); ?>