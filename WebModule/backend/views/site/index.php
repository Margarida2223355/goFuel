<?php

use hail812\adminlte\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Homepage';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php
$alert = Yii::$app->session->get('alert');
if ($alert) {
    echo Alert::widget([
        'type' => $alert['type'],
        'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
    ]);

    Yii::$app->session->remove('alert');
}
?>
<div class="container-fluid mt-5">
    <div class="row">
        <?php
        switch ($role) {
            case 'Admin':
        ?>
                <div class="col-12">
                    <h3>Users Information</h3>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of users',
                        'number' => $usersCount,
                        'theme' => 'success',
                        'icon' => 'fa fa-users',
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Admins',
                        'body' => $userRoleCounts['Admin'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Managers',
                        'body' => $userRoleCounts['Manager'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'In charges',
                        'body' => $userRoleCounts['Incharge'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Employees',
                        'body' => $userRoleCounts['Employee'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Clients',
                        'body' => $userRoleCounts['Client'],
                    ]) ?>
                </div>
                <div class="col-6">
                    <h3>Stations Information</h3><br>
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of stations',
                        'number' => $stationCount,
                        'theme' => 'info',
                        'icon' => 'fa fa-building',
                    ]) ?>
                </div>
                <div class="col-6"></div>
                <div class="col-6">
                    <h3>Invoices Information</h3><br>
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of Invoices',
                        'number' => $invoiceCount,
                        'theme' => 'info',
                        'icon' => 'fa fa-file-lines',
                    ]) ?>
                </div>
                <div class="col-6"></div>
                <?php
                foreach ($stations as $station) {
                    $invoiceCount = isset($invoiceByStation[$station->id]) ? $invoiceByStation[$station->id] : 0;
                ?>
                    <div class="col-md-4 col-md-3 col-sm-6 col-12">
                        <?= \hail812\adminlte\widgets\Callout::widget([
                            'type' => 'success',
                            'head' => $station->name,
                            'body' => "Number of invoices: " . $invoiceCount,
                        ]) ?>
                    </div>
                <?php
                }
                ?>
            <?php
                break;
            case 'Manager':
            ?>
                <div class="col-12">
                    <?= Html::beginForm(['site/index'], 'post', ['id' => 'station-form', 'class' => 'w-100']) ?>
                    <div class="form-group w-100">
                        <?= Html::dropDownList(
                            'stationId',
                            $stationId,
                            \yii\helpers\ArrayHelper::map($stations, 'id', 'name'),
                            [
                                'id' => 'station-dropdown',
                                'class' => 'form-control w-100',
                                'onchange' => 'this.form.submit();'
                            ]
                        ) ?>
                    </div>
                </div>
                <div class="col-12">
                    <h3>Users Info</h3>

                </div>
                <div class="col-6">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Number of InCharges',
                        'body' => $inchargeCount,
                    ]) ?>
                </div>
                <div class="col-6">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Number of Employees',
                        'body' => $employeeCount,
                    ]) ?>
                </div>
                <div class="col-12">
                    <h3>Invoices Information</h3>
                </div>
                <div class="col-4">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'warning',
                        'head' => 'Pendent',
                        'body' => $invoiceByState[2],
                    ]) ?>
                </div>
                <div class="col-4">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Finished',
                        'body' => $invoiceByState[3],
                    ]) ?>
                </div>
                <div class="col-4">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'danger',
                        'head' => 'Cancelded',
                        'body' => $invoiceByState[4],
                    ]) ?>
                </div>
            <?php
                break;
            case 'In Charge';
            ?>
                <h3>Invoices Information</h3>
                <div class="col-12">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Invoices to Finish',
                        'body' => $invoicesToFinish,
                    ]) ?>
                </div>
                <h3>Items Information</h3>
                <dov class="col-12">
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            'item.description',
                            [
                                'attribute' => 'stock',
                                'label' => 'Current Stock',
                                'value' => function ($model) use ($stationId) {
                                    if ($stationId) {
                                        $item = \common\models\StationItem::findOne(['item_id' => $model->item_id, 'station_id' => $stationId]);
                                        return $item ? $item->stock : 'No Stock Available';
                                    }
                                    return 'Station Not Selected';
                                },
                            ],

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{restock}',
                                'buttons' => [
                                    'restock' => function ($url, $model) {
                                        return Html::a(
                                            '<i class="fa fa-box-open"></i>',
                                            ['station-item/restock', 'item_id' => $model->item_id, 'station_id' => $model->station_id],
                                            [
                                                'title' => 'Restock Item',
                                                'data-confirm' => 'Do you want to restock this item?',
                                                'data-method' => 'post',
                                                'style' => 'color: #007bff; text-decoration: none;',
                                            ]
                                        );
                                    },
                                ],
                            ],
                        ],
                        'summary' => false,
                    ]); ?>
                </dov>
            <?php
                break;
            case 'Employee':
            ?>
                <h3>Invoices Information</h3>
                <div class="col-12">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Invoices to Finish',
                        'body' => $invoicesToFinish,
                    ]) ?>
                </div>
                <?php
                break;
                ?>


        <?php } ?>
    </div>
</div>


<script>
    document.getElementById('station-dropdown').addEventListener('change', function() {
        this.form.submit();
    });
</script>