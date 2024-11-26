<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Station $model */
/** @var array $managersList */

?>

<div class="container-fluid ml-1">

    <?php $form = ActiveForm::begin([
        'action' => $isUpdate
            ? Url::to(['update', 'id' => $model->id])
            : Url::to(['create']),
        'method' => 'post',
    ]); ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name'])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'Address'])->label(false) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true, 'placeholder' => 'Postal Code'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Phone'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'pumps_count')->textInput(['type' => 'number', 'min' => 0, 'placeholder' => 'Number of Pumps'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'manager_id')->dropDownList($managersList, ['prompt' => 'Select a Manager'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <div class="form-group">
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
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>