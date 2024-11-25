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

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $this->render('_form', [
        'model' => $model,
        'view' => $view
    ]) ?>

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
                            return Html::a(
                                '<i class="fa fa-pen" aria-hidden="true"></i>',
                                ['category/view', 'id' => $model->category_id, 'subcategory_id' => $model->id], // Passa os IDs para category/view
                                [
                                    'title' => 'Update',
                                    'style' => 'color: #28a745; text-decoration: none;',
                                ]
                            );
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
    <?php
    if (Yii::$app->user->can('Admin')) {
        if ($isUpdate == true) { ?>
            <h3>Update Subcategory</h3>
        <?php } else { ?>
            <h3>Add New Subcategory</h3>
        <?php } ?>

    <?= $this->render('_subform', [
            'model' => $model,
            'subcategory' => $subcategory,
            'isUpdate' => $isUpdate
        ]);
    } ?>
</div>