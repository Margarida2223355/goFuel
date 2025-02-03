<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Station */
/* @var $managersList array */

$this->title = 'Update Station: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="container-fluid ml-1">

        <?php $form = ActiveForm::begin([
            'action' => $isUpdate
                ? Url::to(['update', 'id' => $model->id])
                : Url::to(['create']),
            'method' => 'post',
        ]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label(false) ?>
        <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address'])->label(false) ?>
        <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true, 'placeholder' => 'Postal Code'])->label(false) ?>
        <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Phone'])->label(false) ?>
        <?= $form->field($model, 'manager_id')->dropDownList($managersList, ['prompt' => 'Select a Manager'])->label(false) ?>
        <?= $form->field($model, 'pumps_count')->textInput(['type' => 'number', 'value' => $currentPumpsCount, 'min' => 0])->label(false) ?>
        <?= $form->field($model, 'imageFile')->fileInput([
            'accept' => 'image/png, image/jpeg, image/jpg'
        ])->label(false) ?>
        <?= Html::submitButton(
            $isUpdate
                ? '<i class="fa fa-save" aria-hidden="true"></i>&ensp;Save'
                : '<i class="fa fa-plus" aria-hidden="true"></i>&ensp;Add',
            [
                'class' => 'btn',
                'style' => $isUpdate
                    ? 'color: green; border-color: green; background-color: transparent; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;'
                    : 'color: green; border-color: green; background-color: transparent; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;',
            ]
        ) ?>
        <?php ActiveForm::end(); ?>

    </div>

</div>