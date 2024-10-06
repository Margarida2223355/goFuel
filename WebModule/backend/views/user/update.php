<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="user-form">

        <!-- Campos do User -->
        <?= $form->field($userForm, 'username')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userForm, 'email')->textInput(['maxlength' => true]) ?>

        <!-- Campos do UserInfo -->
        <?= $form->field($userForm, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userForm, 'nif')->textInput() ?>
        <?= $form->field($userForm, 'role')->dropDownList([
            'Admin' => 'Admin',
            'Manager' => 'Manager',
            'In Charge' => 'In Charge',
            'Employee' => 'Employee'
        ]) ?>
        <?= $form->field($userForm, 'address')->textInput(['maxlength' => true]) ?>
        <?= $form->field($userForm, 'postal_code')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="form-group">
        <?= Html::submitButton('Atualizar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>