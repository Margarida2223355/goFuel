<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */
/* @var $newSubcategory common\models\Subcategory */

$this->title = 'Category: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Categories', 'url' => ['index']];
?>
<div class="category-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="category-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="form-group">
            <label for="category-name">Category Name</label>
            <div class="input-group">
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'id' => 'category-name', 'placeholder' => 'Enter category name']) ?>
                <div class="input-group-append">
                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <h3>Subcategories</h3>

    <?= GridView::widget([
        'dataProvider' => $subcategoriesDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}', // Inclui o botão de delete
                'urlCreator' => function ($action, $model) {
                    return ['subcategory/' . $action, 'id' => $model->id]; // Gera a URL para a ação
                },
            ],
        ],
    ]); ?>

    <h3>Add New Subcategory</h3>

    <?php $form = ActiveForm::begin([
        'action' => ['subcategory/create'], // A ação que processa a criação
        'method' => 'post',
    ]); ?>

    <div class="form-group">
        <div class="input-group">
            <!-- Campo hidden para enviar o category_id -->
            <?= Html::hiddenInput('Subcategory[category_id]', $model->id) ?>

            <!-- Campo para a descrição da nova subcategoria -->
            <?= Html::activeTextInput($newSubcategory, 'description', ['class' => 'form-control', 'placeholder' => 'Add new subcategory']) ?>
            <div class="input-group-append">
                <?= Html::submitButton('Add Subcategory', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>