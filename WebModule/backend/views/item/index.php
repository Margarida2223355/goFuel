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

    <?= Html::beginForm(['item/index'], 'post', ['id' => 'station-form', 'class' => 'w-100']) ?>
    <div class="form-group w-100">
        <?= Html::dropDownList(
            'stationId',
            $stationId,
            \yii\helpers\ArrayHelper::map($stations, 'id', 'name'),
            [
                'prompt' => 'Select a Station',
                'id' => 'station-dropdown',
                'class' => 'form-control w-100',
                'onchange' => 'this.form.submit();'
            ]
        ) ?>
    </div>
    <?= Html::endForm() ?>
    <br>
    <?php if ($stationId): ?>
        <div class="item-form mb-3 w-100 justify-content-center">
            <?php $form = ActiveForm::begin([
                'action' => ['item/associate'],
                'method' => 'post',
                'options' => ['class' => 'w-100'],
            ]); ?>

            <?= Html::hiddenInput('station_id', $stationId) ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'item_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\common\models\Item::find()->all(), 'id', 'description'),
                        ['prompt' => 'Select an Item', 'class' => 'form-control w-100']
                    )->label(false) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'price')->textInput([
                        'type' => 'number',
                        'step' => '0.01',
                        'class' => 'form-control w-100',
                        'placeholder' => 'Enter price'
                    ])->label(false) ?>
                </div>
                <div class="me-2">
                    <?= Html::submitButton('<i class="fa fa-plus" aria-hidden="true"></i>&ensp;Add Item', [
                        'class' => 'btn d-flex align-items-center justify-content-center',
                        'style' => 'color: green; border-color: green; background-color: transparent; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;',
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
            'id',
            'item.description',
            'price',
            [
                'attribute' => 'stock',
                'label' => 'Current Stock',
                'value' => function ($model) use ($stationId) {
                    if ($stationId) {
                        $item = \common\models\StationItem::findOne(['item_id' => $model->id, 'station_id' => $stationId]);
                        return $item ? $item->stock : 'No Stock Available';
                    }
                    return 'Station Not Selected';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {restock} {delete}',
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
                    'restock' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-box-open"></i>',
                            ['item/restock', 'id' => $model->id],
                            [
                                'title' => 'Restock Item',
                                'data-confirm' => 'Do you want to restock this item?',
                                'data-method' => 'post',
                                'style' => 'color: #007bff; text-decoration: none;',
                            ]
                        );
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>
</div>

<script>
    document.getElementById('station-dropdown').addEventListener('change', function() {
        this.form.submit();
    });
</script>