<?php ob_start() ?>

<div class="admin-content margin-top">
    <div class="flex flex-justify-between">
    <div id="chartUsers" class="card-2" style="height: 300px; width: 49%;"></div>
    <div id="chartArticles" class="card-2" style="height: 300px; width: 49%;"></div>
    </div>

    <?php $chartUsers = \Knetwork\Models\User::chart(self::dateLastWeek()); ?>
    <?php $chartArticles = \Knetwork\Models\Article::chart(self::dateLastWeek()); ?>

    <script src="app/public/js/charts.js"></script>
    <script src="app/public/js/libs/canvasjs.min.js"></script>
    <script type="text/javascript">displayChartUsers(<?= json_encode($chartUsers) ?>);</script>
    <script type="text/javascript">displayChartArticles(<?= json_encode($chartArticles) ?>);</script>
</div>

<?php $charts = ob_get_clean(); ?>