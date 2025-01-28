<?php

use common\models\StationItem;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */

$this->title = 'Invoice ' . $model->generateFinalCode();
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Master Detail';
\yii\web\YiiAsset::register($this);
?>
<?php
$alert = Yii::$app->session->get('alert');
if ($alert != null) {
    echo Alert::widget([
        'type' => $alert['type'],
        'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
    ]);
}
Yii::$app->session->remove('alert');
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center px-5">
        <div class="col-md-5">
            <p><b>Station: </b> <?= Html::encode($model->station->name) ?></p>
            <p><b>Client: </b> <?= Html::encode($model->client->userInfo->name) ?></p>
        </div>
        <div class="col-md-5 px-5">
            <p><b>Date: </b> <?= Html::encode($model->invoice_date) ?></p>
            <p><b>Total Price: </b> <?= Html::encode($model->total . ' €') ?></p>

        </div>
        <div class="col-md-2 px-5">
            <?php
            if ($model->state_id === 2) {
                echo Html::a(
                    'Check',
                    Url::to(['invoice/finish', 'id' => $model->id]),
                    ['class' => 'btn btn-success me-2']
                );
            } ?>
        </div>
    </div>

    <h1>Items</h1>

    <?php if ($model->invoiceLines): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Unit Price (€)</th>
                    <th>Quantity</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model->invoiceLines as $line):
                    $stationItem = StationItem::findOne(['item_id' => $line->item_id, 'station_id' => $model->station_id]);
                ?>
                    <tr>
                        <td><?= Html::encode($line->item->description) ?></td>
                        <td><?= Html::encode($stationItem->price) ?></td>
                        <td><?= Html::encode($line->qty) ?></td>
                        <td><?= Html::encode($line->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No invoice lines available.</p>
    <?php endif; ?>

</div>