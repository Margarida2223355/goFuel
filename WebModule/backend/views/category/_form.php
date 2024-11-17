<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin([
        'action'  => ['category/create'],
        'options' => ['class' => 'form-inline d-flex align-items-center mb-5'],
    ]); ?>

    <?= $form->field($model, 'name', [
        'options' => ['class' => 'form-group mb-0 me-2'],
        'template' => "{input}\n{error}",
    ])->textInput([
        'maxlength' => true,
        'placeholder' => 'New Category Name', // Placeholder para clareza
        'class' => 'form-control',
    ]) ?>

    <?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i>', [
        'class' => 'btn',
        'style' => 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);',
        'title' => 'Add Subcategory'
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>