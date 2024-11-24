<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container-fluid ml-1">

    <?php $form = ActiveForm::begin([
        'action' => ['subcategory/create'],
        'method' => 'post',
    ]); ?>

    <?= Html::activeHiddenInput($subcategory, 'category_id', ['value' => $model->id]) ?>

    <?= Html::activeHiddenInput($subcategory, 'id', ['value' => $subcategory->id]) ?>

    <div class="row">
        <div class="col-md-7">
            <?= $form->field($subcategory, 'description')->textInput([
                'class' => 'form-control',
                'id' => 'subcategory-description',
                'placeholder' => 'Add'
            ])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton(
                $isUpdate
                    ? '<i class="fa fa-save" aria-hidden="true"></i>'
                    : '<i class="fa fa-plus" aria-hidden="true"></i>',
                [
                    'class' => 'btn',
                    'style' => $isUpdate
                        ? 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);'
                        : 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);',
                ]
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>