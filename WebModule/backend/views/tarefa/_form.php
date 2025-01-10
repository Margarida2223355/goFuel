<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tarefa $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tarefa-form">

    <?php $form = ActiveForm::begin([]); ?>
    <div class="row">
        <div class="col-md-10">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Descrição da tarefa'])->label(false) ?>
            <?= $form->field($model, 'user_id')->hiddenInput(['value' => $user_id])->label(false) ?>

        </div>
        <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>