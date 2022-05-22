<?php ob_start(); ?>

<section class="admin-content table-admin">
    <table class="margin-top w100">
        <thead class="theme-d5">
            <tr>
                <th>Id</th>
                <th>Utilisateur</th>
                <!-- <th>Contenu</th> -->
                <th>Longueur</th>
                <th>Image(s)</th>
                <th>Commentaires</th>
                <th>Likes</th>
                <th>Signalement</th>
                <th>Créé le&nbsp;&nbsp;<i class="fa fa-sort-up"></i></th>
                <th>Mise à jour le</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach($articles as $a): ?>
            <tr class="<?= $i % 2 ? 'theme-l3' : 'theme-l2'; ?>">
                <td class="center"><?= $a->__get('id'); ?></td>
                <td><?= \Knetwork\Models\User::find($a->__get('user_id'))->getNames(); ?></td>
                <td><?= strlen($a->__get('content')); ?></td>
                <!-- <td>
                    <?= substr($a->__get('content'), 0, 80); ?>
                    <?= strlen($a->__get('content')) > 80 ? "..." : "" ?>
                </td> -->
                <td class="center"><i class="fa <?= $a->havePictures() ? "fa-circle-check text-green" : "fa-circle-xmark text-red"; ?>"></i></td>
                <td><?= $a->countComments(); ?></td>
                <td><?= $a->countLikes(); ?></td>
                <td>(WIP)</td>
                <td><?= $a->__get('created_at'); ?></td>
                <td><?= $a->__get('updated_at'); ?></td>
                <td class="center">
                    <a href="#" title="Voir l'article (WIP)"><i class="fa fa-eye text-blue"></i></a>
                    <a href="indexadmin.php?action=articleedit&id=<?= $a->__get('id'); ?>"><i class="fa fa-pen text-green"></i></a>
                    <a href="indexadmin.php?action=articledelete&id=<?= $a->__get('id'); ?>" title="Supprimer"><i class="fa fa-trash text-red"></i></a>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</section>


<?php $tableArticles = ob_get_clean(); ?>
