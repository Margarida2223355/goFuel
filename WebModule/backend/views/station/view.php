<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $station common\models\Station */

$this->title = $station->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="station-view">

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?php if (Yii::$app->user->can('Manager') || Yii::$app->user->can('Admin')): ?>
                <?= Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', ['update', 'id' => $station->id], [
                    'title' => 'Atualizar',
                    'style' => 'color: #28a745; text-decoration: none; margin-right: 10px; margin-left: 15px;',
                ]) ?>
            <?php
            endif;
            if (Yii::$app->user->can('Admin')): ?>
                <?= Html::a(
                    '<i class="fa fa-trash" aria-hidden="true"></i>',
                    ['delete', 'id' => $station->id],
                    [
                        'title' => 'Delete',
                        'data-method' => 'post',
                        'data-confirm' => 'Tem certeza que deseja deletar esta associação?',
                        'style' => 'color: #dc3545; text-decoration: none;',
                    ]
                ); ?>
            <?php endif; ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $station,
        'attributes' => [
            'id',
            'name',
            'address',
            'postal_code',
            [
                'label' => 'Manager',
                'value' => $station->manager->name, // Supondo que o manager tenha uma relação 'name' ou 'username'
            ],
        ],
    ]) ?>

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode('Available items') ?></h1>
        <div>
            <?php if (Yii::$app->user->can('Manager') || Yii::$app->user->can('Incharge')): ?>
                <?= Html::a('<i class="fa fa-link" aria-hidden="true"></i>', ['item/index', 'stationId' => $id], [
                    'title' => 'Items page',
                    'style' => 'color: #007bff; text-decoration: none; margin-right: 10px; margin-left: 15px;',
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'header' => 'Identifier',
                'headerOptions' => ['style' => 'width: 100px; white-space: nowrap;'],
            ],
            'item.description',
            'price',
            [
                'attribute' => 'stock',
                'label' => 'Current Stock',
                'value' => function ($model) use ($id) {
                    if ($id) {
                        $item = \common\models\StationItem::findOne(['item_id' => $model->id, 'station_id' => $id]);
                        return $item ? $item->stock : 'No Stock Available';
                    }
                    return 'Station Not Selected';
                },
            ],
        ],
        'summary' => false,
    ]); ?>

</div>