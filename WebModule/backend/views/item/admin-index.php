<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['item/create'], [
            'class' => 'btn',
            'title' => 'Create Item',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id',
            'description',
            [
                'label' => 'Category - Subcategory',
                'value' => function ($model) {
                    return $model->subcategory ? $model->subcategory->category->name . ' - ' . $model->subcategory->description : 'N/A';
                },
            ],
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {reset-password}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                            'title' => 'View',
                            'style' => 'color: #007bff; text-decoration: none;',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', $url, [
                            'title' => 'Update',
                            'style' => 'color: #28a745; text-decoration: none;',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                            'title' => 'Delete',
                            'data-method' => 'post',
                            'data-confirm' => 'Confirm Item Elimination?',
                            'style' => 'color: #dc3545; text-decoration: none;',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>