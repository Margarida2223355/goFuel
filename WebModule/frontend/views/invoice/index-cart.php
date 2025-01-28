<?php

use common\models\Invoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Cart';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Code',
                'value' => function ($model) {
                    return $model->generateFinalCode();
                },
            ],
            'station.name',
            'invoice_date',
            'total',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {pay} {cancel}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                            'title' => 'Visualizar',
                            'style' => 'color: #007bff; text-decoration: none;',
                        ]);
                    },
                    'pay' => function ($url, $model) {
                        return Html::a('<i class="fa fa-euro" aria-hidden="true"></i>', $url, [
                            'title' => 'Pay',
                            'style' => 'color:#28a745; text-decoration: none;',
                        ]);
                    },
                    'cancel' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                            'title' => 'Cancel',
                            'data-method' => 'post',
                            'data-confirm' => 'Are you sure about cancel this invoice?',
                            'style' => 'color: #dc3545; text-decoration: none;',
                        ]);
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>


</div>