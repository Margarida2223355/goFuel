<?php

use common\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fa fa-plus" aria-hidden="true"></i>', ['category/create'], [
            'class' => 'btn',
            'title' => 'Create Category',
            'style' => 'color: green; text-decoration: none; margin-right: 10px; margin-left: 15px;',
        ]) ?>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
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