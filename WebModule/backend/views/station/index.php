<?php

use common\models\Station;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid mt-5 ml-1">

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['station/create'], [
            'class' => 'btn',
            'title' => 'Create station',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'address',
            'postal_code',
            [
                'attribute' => 'manager_id',
                'label' => 'Manager Name',
                'value' => function ($model) {
                    return $model->manager ? $model->manager->name : 'Not assigned';
                }
            ],

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    // O botão delete só será exibido para os admins
                    'delete' => function ($model) {
                        return Yii::$app->user->can('Admin');
                    },
                    // O botão update será exibido para admins e managers
                    'update' => function ($model) {
                        return Yii::$app->user->can('Admin') || Yii::$app->user->can('Manager');
                    },
                ],
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                            'title' => 'Visualizar',
                            'style' => 'color: #007bff; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', $url, [
                            'title' => 'Atualizar',
                            'style' => 'color: #28a745; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                            'title' => 'Delete',
                            'data-method' => 'post',
                            'data-confirm' => 'Tem certeza que deseja apagar esta station?',
                            'style' => 'color: #dc3545; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>

</div>