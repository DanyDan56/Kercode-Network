<?php ob_start() ?>

<div class="admin-content">
    <h1>Dashboard</h1>
    <hr>

    <div class="dashboard-cards-stats flex flex-justify-between w100">
        <div class="card-2 card-stat round white">
            <a href="indexadmin.php?action=users" class="no-decoration" title="Utilisateurs">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Utilisateurs</p>
                        <p class="bold font-large"><?= \Knetwork\Models\User::count(); ?><span class="tag round green margin-left font-small">+2</span></p>
                    </div>
                    <div class="icon right"><i class="fa fa-users text-gray"></i></div>
                </div>
            </a>
        </div>
        <div class="card-2 card-stat round white">
            <a href="indexadmin.php?action=articles" class="no-decoration" title="Articles">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Articles</p>
                        <p class="bold font-large"><?= \Knetwork\Models\Article::count(); ?><span class="tag round green margin-left font-small">+5</span></p>
                    </div>
                    <div class="icon right"><i class="fa fa-newspaper text-gray"></i></div>
                </div>
            </a>
        </div>
        <div class="card-2 card-stat round white">
            <a href="#" class="no-decoration" title="Commentaires">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Commentaires</p>
                        <p class="bold font-large">35<span class="tag round green margin-left font-small">+17</span></p>
                    </div>
                    <div class="icon right"><i class="fa fa-comments text-gray"></i></div>
                </div>
            </a>
        </div>
        <div class="card-2 card-stat round white">
            <a href="#" class="no-decoration" title="Photos">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Photos</p>
                        <p class="bold font-large"><?= \Knetwork\Models\Article::count('article_image'); ?><span class="tag round green margin-left font-small">+9</span></p>
                    </div>
                    <div class="icon right"><i class="fa fa-image text-gray"></i></div>
                </div>
            </a>
        </div>
    </div>
</div>



<?php $dashboard = ob_get_clean(); ?>