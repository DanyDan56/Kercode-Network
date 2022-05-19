<?php ob_start(); ?>

<section class="admin-content table-admin">
    <table class="margin-top w100">
        <thead class="theme-d5">
            <tr>
                <th>Id</th>
                <th>Profil</th>
                <th>Email</th>
                <th># articles</th>
                <th># commentaires</th>
                <th>Créé le&nbsp;&nbsp;<i class="fa fa-sort-up"></i></th>
                <th>Mise à jour le</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $i = 0;
            foreach($users as $u): ?>
            <tr class="<?= $i % 2 ? 'theme-l3' : 'theme-l2'; ?>">
                <td class="center"><?= $u->__get('id'); ?></td>
                <td>
                    <?php if ($u->__get('profileImage') != ""): ?>
                        <img src="./app/private/images/users/<?= $u->__get('id'); ?>/<?= $u->__get('profileImage'); ?>" alt="Profil" class="w22px circle float-left margin-right-small">
                    <?php endif; ?>
                    <?= $u->__get('firstname') . " " . $u->__get('lastname'); ?>
                </td>
                <td><?= $u->__get('email'); ?></td>
                <td><?= $u->countArticles(); ?></td>
                <td><?= $u->countComments(); ?></td>
                <td><?= $u->__get('createdAt'); ?></td>
                <td><?= $u->__get('updatedAt'); ?></td>
                <td class="center">
                    <a href="index.php?action=profile&id=<?= $u->__get('id'); ?>" title="Voir le profil" target="_blank"><i class="fa fa-eye text-blue"></i></a>
                    <a href="indexadmin.php?action=useredit&id=<?= $u->__get('id'); ?>" title="Editer le profil"><i class="fa fa-pen text-green"></i></a>
                    <!-- TODO: Corbeille -->
                    <a href="#" title="Bannir"><i class="fa fa-ban text-red"></i></a>
                </td>
            </tr>
            <?php $i++; endforeach; ?>
        </tbody>
    </table>
</section>


<?php $tableUsers = ob_get_clean(); ?>