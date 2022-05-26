<?php ob_start() ?>

<div class="admin-content margin-top">
    <div id="chart" class="chart card-2 w100"></div>

    <script src="/app/public/js/charts.js"></script>
    <script src="/app/public/js/libs/canvasjs.min.js"></script>
    <script type="text/javascript">displayChart(<?= json_encode($chart); ?>, "Courbe d'évolution pour les 31 derniers jours", 'chart');</script>
</div>

<?php $chart = ob_get_clean(); ?>