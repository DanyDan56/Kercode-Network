<?php ob_start(); ?>

<div class="admin-content">
    <form action="indexadmin.php?action=usereditpost&id=<?= $userToEdit->__get('id'); ?>" id="user-edit" method="POST">
        <div class="flex flex-wrap">
            <h1>
                <a href="indexadmin.php?action=users"><i class="fa fa-arrow-left"></i></a>
                <?= $userToEdit->__get('lastname'); ?> <?= $userToEdit->__get('firstname'); ?> (<?= $userToEdit->__get('id'); ?>)
            </h1>
            <button type="submit" class="btn green right h40px bottom">Enregistrer</button>
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

        <div class="theme-l3 flex">
            <p class="bold margin">
                Compte créé le <?= \Knetwork\Controllers\Controller::dateToFrench($userToEdit->__get('createdAt'), "d F Y H:i:s"); ?><br>
                Dernière mise à jour le <?= \Knetwork\Controllers\Controller::dateToFrench($userToEdit->__get('updatedAt'), "d F Y H:i:s"); ?>
            </p>
            <div class="right margin">
                <select name="role" id="role">
                    <option value="1" <?php if ($userToEdit->isAdmin()) { echo 'selected'; } ?>>Admin</option>
                    <option value="0" <?php if (!$userToEdit->isAdmin()) { echo 'selected'; } ?>>Utilisateur</option>
                </select>
            </div>
        </div>

        <!-- Infos générales -->
        <div class="flex flex-wrap w100">
            <div class="col l4 m5 margin">
                <label for="lastname" class="">Nom</label>
                <input type="text" id="lastname" name="lastname" value="<?= $userToEdit->__get('lastname'); ?>" class="w100">
            </div>
            <div class="col l4 m5 margin">
                <label for="firstname">Prénom</label>
                <input type="text" id="firstname" name="firstname" value="<?= $userToEdit->__get('firstname'); ?>" class="w100">
            </div>
            <div class="col l1 m12 margin order-medium-1 order-small-1">
                <label for="gender">Civilité</label>
                <select name="gender" id="gender">
                    <option value="0" <?php if ($userToEdit->__get('gender') == 0) { echo 'selected'; } ?>>M.</option>
                    <option value="1" <?php if ($userToEdit->__get('gender') == 1) { echo 'selected'; } ?>>Mme.</option>
                </select>
            </div>
        </div>
        <div class="flex flex-wrap w100">
            <div class="col l4 m5 margin">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= $userToEdit->__get('email'); ?>" class="w100">
            </div>
            <div class="col l4 m5 margin">
                <label for="birthday">Date de naissance</label>
                <input type="date" id="birthday" name="birthday" value="<?= $userToEdit->__get('birthdayDate'); ?>" class="w100">
            </div>
        </div>
        <div class="flex flex-wrap w100">
            <div class="col l4 m5 margin">
                <label for="address">Ville</label>
                <input type="text" id="address" name="address" value="<?= $userToEdit->__get('address'); ?>" class="w100">
            </div>
            <div class="col l4 m5 margin">
                <label for="job">Travail</label>
                <input type="text" id="job" name="job" value="<?= $userToEdit->__get('job'); ?>" class="w100">
            </div>
        </div>
    </form>

    <!-- Infos serveur et base de données -->
    <div class="theme-l4">
        <p class="margin">
            Poids des images uploadées sur le serveur: 
            <strong><?= \Knetwork\Controllers\Controller::formatSize(\Knetwork\Controllers\Controller::folderSize("app/private/images/users/" . $userToEdit->__get('id'))) ?></strong><br>
            Nombre d'articles créés: <strong><?= $userToEdit->countArticles(); ?></strong><br>
            Nombre de commentaires: <strong><?= $userToEdit->countComments(); ?></strong>
        </p>
    </div>
</div>

<?php $userDetails = ob_get_clean(); ?>
