<?php

use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $newSubcategory common\models\Subcategory */

$this->title = 'Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group d-flex align-items-center">

        <?= Html::activeTextInput($model, 'name', [
            'class' => 'form-control me-2',
            'id' => 'category-name',
            'placeholder' => 'Enter category name'
        ]) ?>

        <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i>', [
            'class' => 'btn',
            'style' => 'color: blue; border-color: black;',
            'title' => 'Update Category'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <h3>Subcategories</h3>

    <?= GridView::widget([
        'dataProvider' => $subcategoriesDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'description',
            [
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if (Yii::$app->user->can('Admin')) {
                            return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', '#', [
                                'title' => 'Update',
                                'style' => 'color: #28a745; text-decoration: none;',
                                'onclick' => "setSubcategoryData({$model->id}, '{$model->description}'); return false;", // Chama a função JavaScript
                            ]);
                        }
                    },
                    'delete' => function ($url, $model) {
                        if (Yii::$app->user->can('Admin')) {
                            return Html::a(
                                '<i class="fa fa-trash" aria-hidden="true"></i>',
                                ['subcategory/delete', 'id' => $model->id],
                                [
                                    'title' => 'Delete',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Are you sure you want to delete this subcategory?',
                                    'style' => 'color: #dc3545; text-decoration: none;',
                                ]
                            );
                        }
                    },
                ],
            ],
        ],
    ]); ?>
    <?php if (Yii::$app->user->can('Admin')) { ?>
        <h3>Add New Subcategory</h3>

        <?php
        $form = ActiveForm::begin([
            'action' => ['subcategory/create'],
            'method' => 'post',
        ]); ?>

        <?= Html::activeHiddenInput($newSubcategory, 'category_id', ['value' => $model->id]) ?>

        <?= Html::activeHiddenInput($newSubcategory, 'id', ['value' => $newSubcategory->id]) ?>

        <div class="form-group d-flex align-items-center">

            <?= Html::activeTextInput($newSubcategory, 'description', [
                'class' => 'form-control me-2',
                'id' => 'subcategory-description',
                'placeholder' => 'Add new subcategory'
            ]) ?>

            <?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i>', [
                'class' => 'btn',
                'style' => 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);',
                'title' => 'Add Subcategory'
            ]) ?>
        </div>

    <?php ActiveForm::end();
    } ?>
</div>
