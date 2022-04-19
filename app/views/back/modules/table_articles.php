<?php ob_start(); ?>

<section class="admin-content table-admin">
    <table class="margin-top w100">
        <thead class="theme-d5">
            <tr>
                <th>Id</th>
                <th>Contenu</th>
                <th>Image(s)</th>
                <th>Créé le</th>
                <th>Mise à jour le</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($articles as $a): ?>
            <tr class="theme-l3">
                <td class="center"><?= $a->__get('id'); ?></td>
                <td>
                    <?= substr($a->__get('content'), 0, 80); ?>
                    <?= strlen($a->__get('content')) > 80 ? "..." : "" ?>
                </td>
                <td class="center"><i class="fa <?= $a->__get('images') ? "fa-circle-check text-green" : "fa-circle-xmark text-red"; ?>"></i></td>
                <td><?= $a->__get('created_at'); ?></td>
                <td><?= $a->__get('updated_at'); ?></td>
                <td class="center">
                    <a href="#" title="Voir le profil"><i class="fa fa-eye text-blue"></i></a>
                    <a href="#"><i class="fa fa-pen text-green"></i></a>
                    <!-- TODO: Corbeille -->
                    <a href="#" title="Supprimer"><i class="fa fa-trash text-red"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


<?php $tableArticles = ob_get_clean(); ?>