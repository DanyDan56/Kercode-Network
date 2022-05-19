<?php ob_start(); ?>

<section class="admin-content table-admin">
    <table class="margin-top w100">
        <thead class="theme-d5">
            <tr>
                <th>Id</th>
                <th>Contenu</th>
                <th>Créé le&nbsp;&nbsp;<i class="fa fa-sort-up"></i></th>
                <th>Mise à jour le</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach($comments as $c): ?>
            <tr class="<?= $i % 2 ? 'theme-l3' : 'theme-l2'; ?>">
                <td class="center"><?= $c->__get('id'); ?></td>
                <td>
                    <?= substr($c->__get('content'), 0, 100); ?>
                    <?= strlen($c->__get('content')) > 80 ? "..." : "" ?>
                </td>
                <td><?= $c->__get('created_at'); ?></td>
                <td><?= $c->__get('updated_at'); ?></td>
                <td class="center">
                    <a href="#" title="Voir le profil"><i class="fa fa-eye text-blue"></i></a>
                    <a href="indexadmin.php?action=articleedit&id=<?= $c->__get('id'); ?>"><i class="fa fa-pen text-green"></i></a>
                    <a href="#" title="Supprimer"><i class="fa fa-trash text-red"></i></a>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</section>


<?php $tableComments = ob_get_clean(); ?>