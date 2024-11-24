<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Item */
/* @var $form yii\widgets\ActiveForm */
/* @var $subcategories common\models\Subcategory[] */ // Adicione este tipo se necessário

?>

<div class="item-form">

    <?php $form = ActiveForm::begin([
        'action' => $isUpdate
            ? Url::to(['update', 'id' => $model->id])
            : Url::to(['create']),
        'method' => 'post',
    ]); ?>
    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Description'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'restock_qty')->textInput(['placeholder' => 'Restock Quantity'])->label(false) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'subcategory_id')->dropDownList(
                \yii\helpers\ArrayHelper::map($subcategories, 'id', 'description'),
                ['prompt' => 'Select a Subcategory']
            )->label(false) ?>
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