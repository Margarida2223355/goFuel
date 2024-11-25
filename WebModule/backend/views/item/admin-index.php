<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid ml-1">

    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php elseif (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'subcategories' => $subcategories,
        'isUpdate' => $isUpdate
    ]) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_deleted
                        ? Html::tag('i', '', ['class' => 'fa-regular fa-circle-check', 'aria-hidden' => 'true', 'style' => 'color: #28a745']) . ' ' . $model->description
                        : Html::tag('i', '', ['class' => 'fa-regular fa-circle-xmark', 'aria-hidden' => 'true', 'style' => 'color: #dc3545']) . ' ' . $model->description;
                },
            ],
            [
                'label' => 'Category - Subcategory',
                'attribute' => 'category_subcategory',
                'value' => function ($model) {
                    if ($model->subcategory->is_deleted == 1) {
                        return $model->subcategory ? $model->subcategory->category->name . ' - ' . $model->subcategory->description : 'N/A';
                    } else {
                        return 'Category/Subcategory deleted. Please change.';
                    }
                },
            ],
            'restock_qty',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
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
                            'data-confirm' => 'Do you realy want delete this item?',
                            'style' => 'color: #dc3545; text-decoration: none;',
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>