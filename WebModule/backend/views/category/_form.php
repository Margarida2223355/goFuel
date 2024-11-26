<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container-fluid">

    <?php $form = ActiveForm::begin([
        'action' => $view
            ? Url::to(['update', 'id' => $model->id])
            : Url::to(['create']),
        'method' => 'post',
    ]); ?>
    <div class="row">
        <div class="col-md-7">
            <?= $form->field($model, 'name', [])->textInput(['maxlength' => true, 'placeholder' => 'New Category Name', 'class' => 'form-control'])->label(false) ?>
        </div>
        <div class="col-md-2">
            <?= Html::submitButton(
                $view
                    ? '<i class="fa fa-save" aria-hidden="true"></i>'
                    : '<i class="fa fa-plus" aria-hidden="true"></i>',
                [
                    'class' => 'btn',
                    'style' => $view
                        ? 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);'
                        : 'color: green; border-color: black; height: calc(1.5em + .75rem + 2px);',
                    'title' => $view
                        ? 'Update Category'
                        : 'Add Category'
                ]
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>