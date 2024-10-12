<?php

use common\models\Station;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $stations common\models\Station[] */
/* @var $stationId int|null */
/* @var $model app\models\ItemStationForm */ // Certifique-se de que o tipo está correto

$this->title = 'Items - ' . ($stationId ? Station::findOne($stationId)->name : 'All Stations');
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="items-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Formulário para selecionar a estação -->
    <?= Html::beginForm(['item/index'], 'post', ['id' => 'station-form']) ?>
    <?= Html::dropDownList(
        'stationId',
        $stationId,
        \yii\helpers\ArrayHelper::map($stations, 'id', 'name'),
        [
            'prompt' => 'Select a Station',
            'id' => 'station-dropdown', // ID para o JavaScript
            'class' => 'form-control',
            'onchange' => 'this.form.submit();' // Submete o formulário quando seleciona uma estação
        ]
    ) ?>
    <?= Html::endForm() ?>
    <br>
    <?php if ($stationId): ?>
        <div class="item-form mb-3">
            <?php $form = ActiveForm::begin([
                'action' => ['item/associate'],
                'method' => 'post',
                'options' => ['class' => 'form-inline'], // Mantém a classe de formulário em linha
            ]); ?>

            <?= Html::hiddenInput('station_id', $stationId) ?>

            <div class="d-flex justify-content-between">
                <div class="flex-grow-1 me-2">
                    <?= $form->field($model, 'item_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\common\models\Item::find()->all(), 'id', 'description'),
                        ['prompt' => 'Select an Item', 'class' => 'form-control w-100']
                    )->label(false) ?>
                </div>

                <div class="flex-grow-1 me-2">
                    <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'form-control w-100', 'placeholder' => 'Enter price'])->label(false) ?>
                </div>

                <div>
                    <?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i>', [
                        'class' => 'btn',
                        'style' => 'color: green; border-color: black;',
                        'title' => 'Add Item'
                    ]) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item.description', 
            'price',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-pen" aria-hidden="true"></i>',
                            ['item/update-association', 'id' => $model->id],
                            [
                                'title' => 'Atualizar',
                                'style' => 'color: #28a745; text-decoration: none;'
                            ]
                        );
                    },
                    'delete' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-trash" aria-hidden="true"></i>',
                            ['item/delete-association', 'id' => $model->id],
                            [
                                'title' => 'Deletar',
                                'data-method' => 'post',
                                'data-confirm' => 'Tem certeza que deseja deletar esta associação?',
                                'style' => 'color: #dc3545; text-decoration: none;',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>

<script>
    document.getElementById('station-dropdown').addEventListener('change', function() {
        this.form.submit();
    });
</script>