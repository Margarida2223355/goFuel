<?php

use common\models\StationItem;
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
                            'Pay',
                            Url::to(['invoice/pay', 'id' => $model->id]),
                            ['class' => 'btn btn-warning me-2']
                        ) ?>
                        <?= Html::a(
                            'Cancel',
                            Url::to(['invoice/cancel', 'id' => $model->id]),
                            ['class' => 'btn btn-danger me-2']
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
                                    <?php foreach ($model->invoiceLines as $line):
                                        $stationItem = StationItem::findOne(['item_id' => $line->item_id, 'station_id' => $model->station_id]); ?>
                                        <tr>
                                            <td><?= Html::encode($line->item->description) ?></td>
                                            <td><?= Html::encode($stationItem->price) ?></td>
                                            <td><?= Html::encode(round($line->qty, 2)) ?></td>
                                            <td><?= Html::encode($line->total) ?></td>
                                            <?php if ($model->state_id == 1): ?>
                                                <td>
                                                    <?= Html::beginForm(['invoiceline/update-quantity', 'id' => $line->id], 'post') ?>
                                                    <div class="input-group">
                                                        <?php
                                                        if ($line->item->subcategory->category->id == 1 || $line->item->subcategory->category->id == 2) :
                                                            echo Html::input('number', 'quantity', 1, [
                                                                'class' => 'form-control',
                                                                'style' => 'width: 100px; margin-right: 5px;',
                                                                'min' => 0.1,
                                                                'step' => 0.1,
                                                                'title' => 'Quantidade',
                                                            ]);
                                                        else :
                                                            echo Html::input('number', 'quantity', 1, [
                                                                'class' => 'form-control',
                                                                'style' => 'width: 100px; margin-right: 5px;',
                                                                'min' => 1,
                                                                'title' => 'Quantidade',
                                                            ]);
                                                        endif;
                                                        ?>
                                                        <div class="input-group-append">
                                                            <?= Html::submitButton(
                                                                '<i class="fas fa-minus"></i>',
                                                                [
                                                                    'class' => 'btn btn-sm btn-secondary',
                                                                    'name' => 'action',
                                                                    'value' => 'minus',
                                                                    'title' => 'Remove Quantity'
                                                                ]
                                                            ) ?>
                                                            <?= Html::submitButton(
                                                                '<i class="fas fa-plus"></i>',
                                                                [
                                                                    'class' => 'btn btn-sm btn-success',
                                                                    'name' => 'action',
                                                                    'value' => 'plus',
                                                                    'title' => 'Add Quantity'
                                                                ]
                                                            ) ?>
                                                            <?= Html::a(
                                                                '<i class="fas fa-trash"></i>',
                                                                Url::to(['invoiceline/delete', 'id' => $line->id]),
                                                                [
                                                                    'title' => 'Delete',
                                                                    'class' => 'btn btn-sm btn-danger ',
                                                                    'data' => [
                                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                                        'method' => 'post',
                                                                    ],
                                                                ]
                                                            ) ?>
                                                        </div>
                                                    </div>
                                                    <?= Html::endForm() ?>
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