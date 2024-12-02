<?php

use common\models\Category;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid ml-1">
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
</div>

<div class="d-flex align-items-center mb-3">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->user->can("Admin")): ?>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['category/create'], [
            'class' => 'btn',
            'title' => 'Create Category',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    <?php endif; ?>
</div>

<?= $this->render('_form', [
    'model' => $model,
    'view' => $view
]) ?>

<div class="row">
    <div class="col-6 float-left">
        <h6 class="float-left">
            <p class="float-left"><i class="fa-regular fa-circle-xmark" style="color: #dc3545;"></i> - Disabled Category </p><br>
            <p class="float-left"><i class="fa-regular fa-circle-check" style="color: #28a745;"></i> - Enabled Category </p>
        </h6>
    </div>
    <div class="col-6 float-right">
        <h6 class="float-right">
            <p class="float-left"><i class="fa fa-eye " style="color: #007bff;"></i> - Master Detail &emsp;&emsp;&emsp;</p>
            <p class="float-left"><i class="fa fa-pen " style="color: #28a745;"></i> - Edit Category &emsp;</p> <br>
            <p class="float-right"><i class="fa fa-redo" style="color: #ffcc00;"></i> - Enable Category &emsp;&emsp;</p>
            <p class="float-right"><i class="fa fa-trash" style="color: #dc3545;"></i> - Desable Category &emsp;</p>
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
        [
            'class' => ActionColumn::class,
            'header' => 'Actions',
            'template' => '{view} {update} {delete} {reset-password}',
            'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                        'title' => 'View',
                        'style' => 'color: #007bff; text-decoration: none;',
                    ]);
                },
                'update' => function ($url, $model) {
                    if (Yii::$app->user->can('Admin')) {
                        return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', $url, [
                            'title' => 'Update',
                            'style' => 'color: #28a745; text-decoration: none;',
                        ]);
                    }
                    return '';
                },

                'delete' => function ($url, $model) {
                    if (Yii::$app->user->can('Admin')) {
                        if ($model->is_deleted == false) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                                'title' => 'Desable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Category Disablement?',
                                'style' => 'color: #dc3545; text-decoration: none;',
                            ]);
                        } else {
                            return Html::a('<i class="fa fa-redo" aria-hidden="true"></i>', $url, [
                                'title' => 'Enable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Category Enablement?',
                                'style' => 'color: #ffcc00; text-decoration: none;',
                            ]);
                        }
                    }
                    return '';
                },
            ],
        ],
    ],
    'summary' => false,
]); ?>
</div>