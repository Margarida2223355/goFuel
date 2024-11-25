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


    <?= $this->render('_form', [
        'model' => $model,
        'view' => $view
    ]) ?>
    <h3>Subcategories</h3>
    <div class="row">
        <div class="col-6 float-left">
            <h6>
                <i class="fa-regular fa-circle-check" style="color: #28a745;"></i> - Enabled Subcategory &emsp;
                <i class="fa-regular fa-circle-xmark" style="color: #dc3545;"></i> - Disabled Subcategory
            </h6>
        </div>
        <div class="col-6 float-right">
            <h6 class="float-right">
                <i class="fa fa-pen" style="color: #28a745;"></i> - Edit Subcategory &emsp;
                <i class="fa fa-redo" style="color: #ffcc00;"></i> - Enable Subcategory &emsp;
                <i class="fa fa-trash" style="color: #dc3545;"></i> - Desable Subcategory
            </h6>
        </div>
    </div>



    <?= GridView::widget([
        'dataProvider' => $subcategoriesDataProvider,
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
                'class' => ActionColumn::class,
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        if (Yii::$app->user->can('Admin')) {
                            return Html::a(
                                '<i class="fa fa-pen" aria-hidden="true"></i>',
                                ['category/view', 'id' => $model->category_id, 'subcategory_id' => $model->id], // Passa os IDs para Subcategory/view
                                [
                                    'title' => 'Update',
                                    'style' => 'color: #28a745; text-decoration: none;',
                                ]
                            );
                        }
                    },
                    'delete' => function ($url, $model) {
                        if (Yii::$app->user->can('Admin')) {
                            if ($model->is_deleted == false) {
                                return Html::a(
                                    '<i class="fa fa-redo" aria-hidden="true"></i>',
                                    ['subcategory/delete', 'id' => $model->id],
                                    [
                                        'title' => 'Enable',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Confirm Subcategory Enablement?',
                                        'style' => 'color: #ffcc00; text-decoration: none;',
                                    ]
                                );
                            } else {
                                return Html::a(
                                    '<i class="fa fa-trash" aria-hidden="true"></i>',
                                    ['subcategory/delete', 'id' => $model->id],
                                    [
                                        'title' => 'Desable',
                                        'data-method' => 'post',
                                        'data-confirm' => 'Confirm Subcategory Disablement?',
                                        'style' => 'color: #dc3545; text-decoration: none;',
                                    ]
                                );
                            }
                        }
                    },
                ],
            ],
        ],
        'summary' => false,
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