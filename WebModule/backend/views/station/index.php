<?php

use common\models\Station;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Stations';
$this->params['breadcrumbs'][] = $this->title;
?>
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
<div class="container-fluid ml-1">
    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?php echo $this->render('_form', [
        'model' => $model,
        'managersList' => $managersList,
        'isUpdate' => $isUpdate,
        'currentPumpsCount' => $currentPumpsCount,
    ]);  ?>

    <div class="row">
        <div class="col-6 float-left">
            <h6>
                <i class="fa-regular fa-circle-check" style="color: #28a745;"></i> Enabled Station &emsp;
                <i class="fa-regular fa-circle-xmark" style="color: #dc3545;"></i> Disabled Station
            </h6>
        </div>
        <div class="col-6 float-right">
            <h6 class="float-right">
                <i class="fa fa-eye" style="color: #007bff;"></i> Master Detail &emsp;
                <i class="fa fa-pen" style="color: #28a745;"></i> Edit Station &emsp;
                <i class="fa fa-redo" style="color: #ffcc00;"></i> Enable Station &emsp;
                <i class="fa fa-trash" style="color: #dc3545;"></i> Desable Station
            </h6>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_deleted
                        ? Html::tag('i', '', ['class' => 'fa-regular fa-circle-xmark', 'aria-hidden' => 'true', 'style' => 'color: #dc3545']) . ' ' . $model->name
                        : Html::tag('i', '', ['class' => 'fa-regular fa-circle-check', 'aria-hidden' => 'true', 'style' => 'color: #28a745']) . ' ' . $model->name;
                },
            ],
            'address',
            'postal_code',
            [
                'attribute' => 'manager_id',
                'label' => 'Manager Name',
                'value' => function ($model) {
                    return $model->manager ? $model->manager->userInfo->name : 'Not assigned';
                }
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Actions',
                'template' => '{view} {update} {delete}',
                'visibleButtons' => [
                    'delete' => function ($model) {
                        return Yii::$app->user->can('Admin');
                    },
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
                        if ($model->is_deleted == false) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                                'title' => 'Desable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Station Disablement?',
                                'style' => 'color: #dc3545; text-decoration: none;',
                            ]);
                        } else {
                            return Html::a('<i class="fa fa-redo" aria-hidden="true"></i>', $url, [
                                'title' => 'Enable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Station Enablement?',
                                'style' => 'color: #ffcc00; text-decoration: none;',
                            ]);
                        }
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>

</div>