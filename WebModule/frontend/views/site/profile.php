<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Profile';
?>

<div class="d-flex align-items-center mb-3">
    <h1 class="me-3"><?= Html::encode($this->title) ?></h1>
</div>

<div class="user-profile-form">

    <?php $form = ActiveForm::begin(/*['id' => 'user-profile-form-id']*/); ?>

    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->input('email') ?>
    <?= $form->field($model, 'nif')->textInput() ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <?= $form->field($model, 'address')->textInput() ?>
    <?= $form->field($model, 'postal_code')->textInput() ?>
    <?= $form->field($model, 'phone')->textInput() ?>
    <br>
    <?= Html::submitButton('<i class="fa fa-save" aria-hidden="true"></i>&ensp;Update Profile', [
        'class' => 'btn d-flex align-items-center justify-content-center',
        'style' => 'color: green; border-color: green; background-color: transparent; float: right; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;',
        'title' => 'Update Profile'
    ]) ?>
    <?php ActiveForm::end(); ?>

</div>