<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $station common\models\Station */
/* @var $items common\models\Item[] */
/* @var $availableItems common\models\Item[] */

$this->title = 'Station: ' . $station->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="station-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $station,
        'attributes' => [
            'name',
            'address',
            'postal_code',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin([
        'action' => ['station/add-item'],
        'method' => 'post',
    ]); ?>

    <?= Html::hiddenInput('station_id', $station->id) ?> <!-- Passa o ID da estação -->

    <div class="form-group">
        <div class="input-group">
            <?= Html::dropDownList('item_id', null, \yii\helpers\ArrayHelper::map($availableItems, 'id', 'description'), [
                'class' => 'form-control',
                'prompt' => 'Select an item',
            ]) ?>
            <?= Html::textInput('price', '', ['class' => 'form-control', 'placeholder' => 'Enter item price']) ?>
            <div class="input-group-append">
                <?= Html::submitButton('Add Item', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <h4>Items Available at This Station</h4>

    <?= GridView::widget([
        'dataProvider' => $itemsDataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item.description',  // Descrição do item
            [
                'label' => 'Price',
                'value' => function ($model) {
                    return Yii::$app->formatter->asCurrency($model->price);
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        // Gera a URL para a ação de delete do StationItem
                        $deleteUrl = ['station-item/delete', 'id' => $model->id]; // Ajuste a URL conforme necessário

                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $deleteUrl, [
                            // 'title' => 'Deletar',
                            // 'data-method' => 'post',
                            // 'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                            // 'style' => 'color: #dc3545; text-decoration: none',

                            'title' => 'Delete Item',
                            'data-confirm' => 'Are you sure you want to delete this item?',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'style' => 'color: #dc3545; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>

</div>