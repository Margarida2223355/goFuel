<?php

use common\models\Invoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'client.userInfo.name',
            'station.name',
            'total',
            'state.description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{finish} {view}',
                'buttons' => [
                    'finish' => function ($url, $model, $key) {
                        if ($model->state_id == 2) {
                            return Html::a('<i class="fas fa-clipboard-check"></i>', ['invoice/finish', 'id' => $model->id], [
                                'title' => 'Finish',
                                'class' => 'action-icon',
                                'style' => 'color: #28a745; text-decoration: none;'
                            ]);
                        }
                        return '';
                    },
                    'view' => function ($url, $model, $key) {
                        if ($model->state_id != 1) {
                            return Html::a('<i class="fas fa-eye"></i>', ['invoice/view', 'id' => $model->id], [
                                'title' => 'Ver',
                                'class' => 'action-icon'
                            ]);
                        }
                        return '';
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>



</div>