<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */

$this->title = Yii::$app->name . ' | Invoice ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<h1><?= Html::encode('Invoice ' . $model->id . ' | Details') ?></h1>

<div class="container-xxl py-3 ">
    <div class="container">
        <div class="col-md-12 wow fadeIn justify-content-center px-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <p><b>Station: </b> <?= Html::encode($model->station->name) ?></p>
                    <p><b>Client: </b> <?= Html::encode($model->client->userInfo->name) ?></p>
                    <p><b>State: </b> <?= Html::encode($model->state->description) ?></p>
                </div>
                <div class="col-md-6 px-5">
                    <p><b>Date: </b> <?= Html::encode($model->invoice_date) ?></p>
                    <p><b>Total Price: </b> <?= Html::encode($model->total . ' €') ?></p>
                    <?php if ($model->state_id == 1): ?>
                        <?= Html::a(
                            'Pay Invoice',
                            Url::to(['invoice/pay', 'id' => $model->id]),
                            ['class' => 'btn btn-warning me-2']
                        ) ?>
                        <?= Html::a(
                            'Cancel Invoice',
                            Url::to(['invoice/cancel', 'id' => $model->id]),
                            ['class' => 'btn btn-warning me-2']
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-xxl py-3">
    <div class="container">
        <div class="col-md-12 wow fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($model->invoiceLines): ?>
                        <ul>
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Unit Price (€)</th>
                                        <th>Quantity</th>
                                        <th>Total (€)</th>
                                        <?php if ($model->state_id == 1): ?>
                                            <th>Actions</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($model->invoiceLines as $line): ?>
                                        <tr>
                                            <td><?= Html::encode($line->item->description) ?></td>
                                            <td><?= Html::encode($line->total / $line->qty) ?></td>
                                            <td><?= Html::encode($line->qty) ?></td>
                                            <td><?= Html::encode($line->total) ?></td>
                                            <?php if ($model->state_id == 1): ?>
                                                <td>
                                                    <?= Html::a(
                                                        '<i class="fas fa-minus"></i>',
                                                        Url::to(['invoiceline/minus', 'id' => $line->id]),
                                                        ['title' => 'Minus', 'class' => 'btn btn-sm btn-secondary']
                                                    ) ?>
                                                    <?= Html::a(
                                                        '<i class="fas fa-trash"></i>',
                                                        Url::to(['invoiceline/delete', 'id' => $line->id]),
                                                        [
                                                            'title' => 'Delete',
                                                            'class' => 'btn btn-sm btn-danger',
                                                            'data' => [
                                                                'confirm' => 'Are you sure you want to delete this item?',
                                                                'method' => 'post',
                                                            ],
                                                        ]
                                                    ) ?>
                                                    <?= Html::a(
                                                        '<i class="fas fa-plus"></i>',
                                                        Url::to(['invoiceline/plus', 'id' => $line->id]),
                                                        ['title' => 'Plus', 'class' => 'btn btn-sm btn-success']
                                                    ) ?>
                                                </td>
                                            <?php endif ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p>No invoice lines available.</p>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>