<?php

use common\models\Station;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserForm */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="container-fluid ml-1">

    <?php
    $actionUrl = $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id];

    $form = ActiveForm::begin([
        'action' => Url::to($actionUrl),
        'method' => 'post',
    ]);
    ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nif')->textInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?php
    if ($model->id == null) :
        echo $form->field($model, 'role')->dropDownList(
            $model->getAvailableRoles(),
            ['prompt' => 'Select a Role']
        );
    endif; ?>

    <?= $form->field($model, 'station_id')->dropDownList(
        ArrayHelper::map(Station::find()->all(), 'id', 'name'),
        ['prompt' => 'Select a Station']
    ) ?>

    <?= Html::submitButton(
        $model->isNewRecord
            ? '<i class="fa fa-plus" aria-hidden="true"></i>'
            : '<i class="fa fa-save" aria-hidden="true"></i>',
        [
            'class' => 'btn',
            'style' => $model->isNewRecord
                ? 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px) float: right;'
                : 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px) float: right;',
            'title' => $model->isNewRecord
                ? 'Add User'
                : 'Update My Info'
        ]
    ) ?>

    <?php ActiveForm::end(); ?>

</div>