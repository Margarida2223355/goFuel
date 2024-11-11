<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */

$this->title = Yii::$app->name . ' | Check Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Check Invoice';
\yii\web\YiiAsset::register($this);
?>
<div class="invoice-check">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center px-5">
        <div class="col-md-6">
            <p><b>Station: </b> <?= Html::encode($model->station->name) ?></p>
            <p><b>Client: </b> <?= Html::encode($model->client->userInfo->name) ?></p>
        </div>
        <div class="col-md-6 px-5">
            <p><b>Date: </b> <?= Html::encode($model->invoice_date) ?></p>
            <p><b>Total Price: </b> <?= Html::encode($model->total . ' €') ?></p>

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
                <?php foreach ($model->invoiceLines as $line): ?>
                    <tr>
                        <td><?= Html::encode($line->item->description) ?></td>
                        <td><?= Html::encode($line->total / $line->qty) ?></td>
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