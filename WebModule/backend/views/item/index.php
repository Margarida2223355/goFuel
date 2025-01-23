<?php

use common\models\Station;
use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $stations common\models\Station[] */
/* @var $stationId int|null */
/* @var $model app\models\ItemStationForm */ // Certifique-se de que o tipo está correto

$this->title = 'Items - ' . ($stationId ? Station::findOne($stationId)->name : 'All Stations');
$this->params['breadcrumbs'][] = $this->title; ?>
<?php
$alert = Yii::$app->session->get('alert');
if ($alert) {
    echo Alert::widget([
        'type' => $alert['type'],
        'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
    ]);

    Yii::$app->session->remove('alert');
}
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->user->can('manager')): ?>
        <?= Html::beginForm(['item/index'], 'post', ['id' => 'station-form', 'class' => 'w-100']) ?>
        <div class="form-group w-100">
            <?= Html::dropDownList(
                'stationId',
                $stationId,
                \yii\helpers\ArrayHelper::map($stations, 'id', 'name'),
                [
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
                    'action' => $isUpdate
                        ? Url::to(['station-item/update-association', 'station_id' => $model->station_id, 'item_id' => $model->item_id])
                        : Url::to(['station-item/associate', 'station_id' => $stationId, 'item_id' => null]),
                    'method' => 'post',
                    'options' => ['class' => 'w-100'],
                ]); ?>

                <?= Html::hiddenInput('station_id', $stationId) ?>

                <div class="row">
                    <div class="col-md-5">
                        <?= $form->field($model, 'item_id')->dropDownList(
                            \yii\helpers\ArrayHelper::map(\common\models\Item::find()->all(), 'id', 'description'),
                            [
                                'prompt' => 'Select an Item',
                                'class' => 'form-control w-100',
                                'disabled' => $isUpdate
                            ]
                        )->label(false) ?>
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, 'price')->textInput([
                            'type' => 'number',
                            'step' => '0.01',
                            'class' => 'form-control w-100',
                            'placeholder' => 'Enter price',
                            'value' => $model->price,
                        ])->label(false) ?>
                    </div>
                    <div class="col-md-2">
                        <?= Html::submitButton(
                            $isUpdate
                                ? '<i class="fa fa-save" aria-hidden="true"></i>&ensp;Save Changes'
                                : '<i class="fa fa-plus" aria-hidden="true"></i>&ensp;Add Item',
                            [
                                'class' => 'btn d-flex align-items-center justify-content-center',
                                'style' => $isUpdate
                                    ? 'color: green; border-color: green; background-color: transparent; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;'
                                    : 'color: green; border-color: green; background-color: transparent; border-width: 2px; border-style: solid; border-radius: 5px; padding: 6px 10px;',
                            ]
                        ) ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'item.description',
            [
                'attribute' => 'item.description',

                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_deleted
                        ? Html::tag('i', '', ['class' => 'fa-regular fa-circle-xmark', 'aria-hidden' => 'true', 'style' => 'color: #dc3545']) . ' ' . $model->item->description
                        : Html::tag('i', '', ['class' => 'fa-regular fa-circle-check', 'aria-hidden' => 'true', 'style' => 'color: #28a745']) . ' ' . $model->item->description;
                },
            ],
            'price',
            [
                'attribute' => 'stock',
                'label' => 'Current Stock',
                'value' => function ($model) use ($stationId) {
                    if ($stationId) {
                        $item = \common\models\StationItem::findOne(['item_id' => $model->item_id, 'station_id' => $stationId]);
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
                        if (Yii::$app->user->can('StationItemUpdateAssociationPermission')) { // Apenas para a role 'manager'
                            return Html::a(
                                '<i class="fa fa-pen" aria-hidden="true"></i>',
                                ['item/update-association', 'station_id' => $model->station_id, 'item_id' => $model->item_id],
                                [
                                    'title' => 'Atualizar',
                                    'style' => 'color: #28a745; text-decoration: none;'
                                ]
                            );
                        }
                        return null; // Oculta o botão se a condição não for satisfeita
                    },
                    'delete' => function ($url, $model) {
                        if (Yii::$app->user->can('StationItemDeleteAssociationPermission')) { // Apenas para a role 'manager'
                            return Html::a(
                                '<i class="fa fa-trash" aria-hidden="true"></i>',
                                ['station-item/delete-association', 'station_id' => $model->station_id, 'item_id' => $model->item_id],
                                [
                                    'title' => 'Deletar',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Do you really want to delete this?',
                                    'style' => 'color: #dc3545; text-decoration: none;',
                                ]
                            );
                        }
                        return null; // Oculta o botão se a condição não for satisfeita
                    },
                    'restock' => function ($url, $model) {
                        if (Yii::$app->user->can('ItemRestockPermission')) { // Apenas para a role 'incharge'
                            return Html::a(
                                '<i class="fa fa-box-open"></i>',
                                ['station-item/restock', 'item_id' => $model->item_id, 'station_id' => $model->station_id],
                                [
                                    'title' => 'Restock Item',
                                    'data-confirm' => 'Do you want to restock this item?',
                                    'data-method' => 'post',
                                    'style' => 'color: #007bff; text-decoration: none;',
                                ]
                            );
                        }
                        return null; // Oculta o botão se a condição não for satisfeita
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