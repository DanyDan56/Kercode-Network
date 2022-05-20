<!-- On change le titre-->
<?php $title = 'Connexion - Kercode Network'; ?>

<?php ob_start(); ?>

<div class="container content margin-top">
    <h1 class="center">Bienvenue sur Kercode Network</h1>
</div>

<section class="content flex flex-justify-center flex-wrap">
    <div class="col l5 m8 margin">
        <figure class="no-margin">
            <img src="./app/public/images/demo.jpg" alt="Image de démo du site" class="w100 border">
            <figcaption class="theme-d2 center no-margin">Image de démo du site</figcaption>
        </figure>
    </div>
    <div class="col l5 m8 margin hfit order-medium-1 order-small-1">
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
        <p class="center margin"><b>Kercode Network</b> est un petit site de réseau social créé pour le projet final de la formation du <i>GRETA Kercode 2022</i>.<br>
        <a href="index.php?action=register"><strong>Inscrivez-vous</strong></a> dès maintenant pour découvrir les fonctionnalités du site.</p>
    </div>
</section>

<!-- Footer - Copyright -->
<footer class="theme-l3 margin-top">
    <p class="center">Copyright Kercode Network &copy; Daniel Goulard - Tous droits réservés </p>
</footer>

<?php $content = ob_get_clean(); ?>

<!-- Load the template -->
<?php require 'templates/template.php'; ?>