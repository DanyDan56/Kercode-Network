<!-- On change le titre -->
<?php $title = 'Inscription - Kercode Network'; ?>

<?php ob_start(); ?>

<section class="container content w30 margin-top">
    <div class="card-2 round white">
        <div class=" padding-large">
            <h2 class="center">Inscrivez-vous dès maintenant</h2>
            <p class="w100 center">C'est rapide et facile.</p>
            <hr>

            <!-- On gère les exceptions -->
            <?php try {
                if(isset($e)) { throw $e; }
            } catch(\Exception $e) { ?>
                <?php if($e->getCode() === 0): ?>
                    <div class="info-box margin-bottom"><p><?= $e->getMessage(); ?></p></div>
                <?php elseif($e->getCode() === 3): ?>
                    <div class="alert-box margin-bottom"><p><?= $e->getMessage(); ?></p></div>
                <?php endif; ?>
            <?php } ?>

            <form id="register" action="index.php?action=registerpost" method="POST" class="flex flex-wrap flex-justify-between" enctype="multipart/form-data">
                <!-- Gender -->
                <!-- <div class="w100 margin-bottom">
                    <input type="radio" name="gender" id="man" value="1" checked><label for="man" class="margin-right">Homme</label>
                    <input type="radio" name="gender" id="woman" value="0"><label for="woman">Femme</label>
                </div> -->
                <!-- Firstname -->
                <input type="text" name="firstname" id="firstname" class="w48 margin-bottom" placeholder="Prénom" required>
                <!-- Lastname -->
                <input type="text" name="lastname" id="lastname" class="w48 margin-bottom" placeholder="Nom de famille" required>
                <!-- Email -->
                <input type="email" name="email" id="email" class="w100 margin-bottom" placeholder="Entrez votre email" required>
                <!-- Password -->
                <input type="password" name="password" id="password" class="w100 margin-bottom" placeholder="Nouveau mot de passe" required>
                <input type="password" name="confirm_password" id="confirm_password" class="w100 margin-bottom" placeholder="Confirmez votre mot de passe" required>
                <!-- Image Profile -->
                <label for="image_profile">Photo de profil</label>
                <input type="hidden" name="MAX_FILE_SIZE" value="2000000"> <!-- Max Size 2mo -->
                <input type="file" name="image_profile" id="image_profile" accept=".png, .jpg, .jpeg">
                <!-- Birthday Date -->
                <label for="birthday">Date de naissance</label>
                <input type="date" name="birthday" id="birthday" class="w100 margin-bottom" required>

                <!-- TODO: RGPD -->
                <button type="submit" class="btn btn-block green">S'inscrire</button>
                <p class="w100 center"><a href="index.php" title="Connectez-vous">Vous posséedez déjà un compte ? Connectez-vous</a></p>
            </form>
        </div>
    </div>
</section>

<?php $content = ob_get_clean(); ?>

<!-- Load the template -->
<?php require 'templates/template.php'; ?>