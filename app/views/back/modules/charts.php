<?php ob_start() ?>

<div class="admin-content margin-top">
    <h2 class="center">Statistiques de la semaine</h2>
    <div class="flex flex-justify-between flex-wrap">
        <div id="chartUsers" class="chart card-2"></div>
        <div id="chartArticles" class="chart card-2"></div>
    </div>

    <script src="app/public/js/charts.js"></script>
    <script src="app/public/js/libs/canvasjs.min.js"></script>
    <script type="text/javascript">displayChartUsers(<?= json_encode($chartUsers) ?>);</script>
    <script type="text/javascript">displayChartArticles(<?= json_encode($chartArticles) ?>);</script>
</div>

<?php $charts = ob_get_clean(); ?>