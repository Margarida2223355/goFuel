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
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'nif')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'postal_code')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php
            if ($model->id == null) :
                echo $form->field($model, 'role')->dropDownList(
                    $model->getAvailableRoles(),
                    ['prompt' => 'Select a Role']
                );
            endif; ?>
        </div>
        <div class="col-md-12" style="display: flex; align-items: center; gap: 10px;">
            <div style="flex: 1;">
                <?= $form->field($model, 'station_id')->dropDownList(
                    ArrayHelper::map(Station::find()->all(), 'id', 'name'),
                    ['prompt' => 'Select a Station']
                )->hint('If you selected Admin or Manager, you do not need to select a station.') ?>
            </div>
            <div>
                <div class="form-group">
                    <?= Html::submitButton(
                        $model->isNewRecord
                            ? '<i class="fa fa-plus" aria-hidden="true"></i>'
                            : '<i class="fa fa-save" aria-hidden="true"></i>',
                        [
                            'class' => 'btn',
                            'style' => 'color: green; border-color: black;',
                            'title' => $model->isNewRecord ? 'Add User' : 'Update My Info'
                        ]
                    ) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>