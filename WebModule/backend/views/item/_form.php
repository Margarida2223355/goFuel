<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
/* @var $subcategories common\models\Subcategory[] */ // Adicione este tipo se necessário

?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subcategory_id')->dropDownList(
        \yii\helpers\ArrayHelper::map($subcategories, 'id', 'description'), // Mapeia subcategorias
        ['prompt' => 'Select a Subcategory'] // Prompt inicial
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>