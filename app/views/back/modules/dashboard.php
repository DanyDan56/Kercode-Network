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
                        <p class="bold font-large no-wrap"><?= $nbUsers; ?>
                            <?php if ($newUsers == 0): ?>
                                <span class="tag round yellow margin-left font-small">+<?= $newUsers; ?></span>
                            <?php elseif ($newUsers > 0): ?>
                                <span class="tag round green margin-left font-small">+<?= $newUsers; ?></span>
                            <?php else: ?>
                                <span class="tag round red margin-left font-small">-<?= $newUsers; ?></span>
                            <?php endif; ?>
                        </p>
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
                        <p class="bold font-large no-wrap"><?= $nbArticles ?>
                            <?php if ($newArticles == 0): ?>
                                <span class="tag round yellow margin-left font-small">+<?= $newArticles; ?></span>
                            <?php elseif ($newArticles > 0): ?>
                                <span class="tag round green margin-left font-small">+<?= $newArticles; ?></span>
                            <?php else: ?>
                                <span class="tag round red margin-left font-small">-<?= $newArticles; ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="icon right"><i class="fa fa-newspaper text-gray"></i></div>
                </div>
            </a>
        </div>
        <div class="card-2 card-stat round white">
            <a href="indexadmin.php?action=comments" class="no-decoration" title="Commentaires">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Commentaires</p>
                        <p class="bold font-large no-wrap"><?= $nbComments ?>
                            <?php if ($newComments == 0): ?>
                                <span class="tag round yellow margin-left font-small">+<?= $newComments; ?></span>
                            <?php elseif ($newComments > 0): ?>
                                <span class="tag round green margin-left font-small">+<?= $newComments; ?></span>
                            <?php else: ?>
                                <span class="tag round red margin-left font-small">-<?= $newComments; ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="icon right"><i class="fa fa-comments text-gray"></i></div>
                </div>
            </a>
        </div>
        <div class="card-2 card-stat round white">
            <a href="#" class="no-decoration" title="Photos">
                <div class="container flex no-margin">
                    <div>
                        <p class="text-gray">Images</p>
                        <p class="bold font-large no-wrap"><?= $nbImages ?>
                            <?php if ($newImages == 0): ?>
                                <span class="tag round yellow margin-left font-small">+<?= $newImages; ?></span>
                            <?php elseif ($newImages > 0): ?>
                                <span class="tag round green margin-left font-small">+<?= $newImages; ?></span>
                            <?php else: ?>
                                <span class="tag round red margin-left font-small">-<?= $newImages; ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="icon right"><i class="fa fa-image text-gray"></i></div>
                </div>
            </a>
        </div>
    </div>
</div>



<?php $dashboard = ob_get_clean(); ?>