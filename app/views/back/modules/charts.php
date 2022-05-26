<?php ob_start() ?>

<div class="admin-content margin-top">
    <h2 class="center">Statistiques de la semaine</h2>
    <div class="flex flex-justify-between flex-wrap">
        <div id="chartUsers" class="chart card-2 margin-bottom"></div>
        <div id="chartArticles" class="chart card-2 margin-bottom"></div>
        <div id="chartComments" class="chart card-2"></div>
    </div>

    <script src="app/public/js/charts.js"></script>
    <script src="app/public/js/libs/canvasjs.min.js"></script>
    <script type="text/javascript">displayChart(<?= json_encode($chartUsers) ?>, 'Comptes', 'chartUsers');</script>
    <script type="text/javascript">displayChart(<?= json_encode($chartArticles) ?>, 'Articles', 'chartArticles');</script>
    <script type="text/javascript">displayChart(<?= json_encode($chartComments) ?>, 'Commentaires', 'chartComments');</script>
</div>

<?php $charts = ob_get_clean(); ?>