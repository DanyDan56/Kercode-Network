<!-- On change le titre-->
<?php $title = 'Connexion - Kercode Network'; ?>

<?php ob_start(); ?>

<div class="container content margin-top">
    <h1 class="center">Bienvenue sur Kercode Network</h1>
</div>

<div class="content w30">
    <div class="card-2 round white">
        <div class="container padding-large">

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

            <!-- Formulaire de connexion -->
            <form id="login" action="index.php?action=loginpost" method="POST">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="margin-bottom" placeholder="Entrez votre email"
                    value="<?php if (isset($email)) { echo $email; } ?>" required>

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" class="margin-bottom" placeholder="Entrez votre mot de passe" required>

                <!-- TODO: Remember me -->

                <button type="submit" class="btn btn-block theme-d1">Se connecter</button>
                <p class="center"><a href="#" title="Réinitialisez votre mot de passe">Mot de passe oublié ?</a></p>    <!-- TODO: -->
                <hr>
                <a href="index.php?action=register" class="btn btn-block green margin-bottom" title="Créer un compte">Créer un compte</a>
            </form>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<!-- Load the template -->
<?php require 'templates/template.php'; ?>