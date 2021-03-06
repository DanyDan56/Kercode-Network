<?php ob_start() ?>

<div class="admin-content">
    <h1>Dashboard</h1>
    <hr>

    <!-- Cartes de statistiques pour une vision rapide (totale + différence journalier) -->
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

    <!-- Graphique de statistiques pour les 7 derniers jours -->
    <div class="margin-top">
        <h2 class="center">Statistiques de la semaine</h2>
        <div class="flex flex-justify-between flex-wrap">
            <div id="chartUsers" class="chart card-2 margin-bottom w49"></div>
            <div id="chartArticles" class="chart card-2 margin-bottom w49"></div>
            <div id="chartComments" class="chart card-2 w49"></div>
            <div id="chartInteractions" class="chart card-2 w49"></div>
        </div>

        <script src="app/public/js/charts.js"></script>
        <script src="app/public/js/libs/canvasjs.min.js"></script>
        <script type="text/javascript">
            displayChart(<?= json_encode($chartUsers) ?>, 'Comptes', 'chartUsers');
            displayChart(<?= json_encode($chartArticles) ?>, 'Articles', 'chartArticles');
            displayChart(<?= json_encode($chartComments) ?>, 'Commentaires', 'chartComments');
            displayChart(<?= json_encode($chartInteractions) ?>, 'Intéractions', 'chartInteractions');
        </script>
    </div>
</div>



<?php $dashboard = ob_get_clean(); ?>