<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i> Save', [
        'class' => 'btn',
        'style' => 'color: blue; border-color: black;',
        'title' => 'Update Category'
    ]) ?>

    <?php ActiveForm::end(); ?>

</div>