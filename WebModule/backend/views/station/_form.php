<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Station */
/* @var $form yii\widgets\ActiveForm */
/* @var $managersList array */

?>

<div class="station-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>

    <!-- Dropdown para selecionar o Manager -->
    <?= $form->field($model, 'manager_id')->dropDownList(
        $managersList,  // Lista de Managers (id => name)
        ['prompt' => 'Select Manager']  // Texto padrão para o dropdown
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>