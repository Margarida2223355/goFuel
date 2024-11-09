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
    <?= Html::beginForm(['item/index'], 'post', ['id' => 'station-form', 'class' => 'w-100']) ?>
    <div class="form-group w-100">
        <?= Html::dropDownList(
            'stationId',
            $stationId,
            \yii\helpers\ArrayHelper::map($stations, 'id', 'name'),
            [
                'prompt' => 'Select a Station',
                'id' => 'station-dropdown', // ID para o JavaScript
                'class' => 'form-control w-100', // Certificando que o dropdown ocupa toda a largura
                'onchange' => 'this.form.submit();' // Submete o formulário quando seleciona uma estação
            ]
        ) ?>
    </div>
    <?= Html::endForm() ?>
    <br>

    <!-- Formulário de associação de itens a uma estação -->
    <?php if ($stationId): ?>
        <div class="item-form mb-3 w-100"> <!-- Mantém "w-100" para ocupar toda a largura -->
            <?php $form = ActiveForm::begin([
                'action' => ['item/associate'],
                'method' => 'post',
                'options' => ['class' => 'w-100'], // Certificando que o form ocupa toda a largura
            ]); ?>

            <?= Html::hiddenInput('station_id', $stationId) ?>

            <div class="row"> <!-- Removi container-fluid e usei apenas row -->
                <!-- Coluna para selecionar item -->
                <div class="col-md-6"> <!-- Coluna ocupando 6/12 da largura -->
                    <?= $form->field($model, 'item_id')->dropDownList(
                        \yii\helpers\ArrayHelper::map(\common\models\Item::find()->all(), 'id', 'description'),
                        ['prompt' => 'Select an Item', 'class' => 'form-control w-100'] // Certifica que o campo ocupa 100% da coluna
                    )->label(false) ?>
                </div>

                <!-- Coluna para o campo de preço -->
                <div class="col-md-3"> <!-- Coluna ocupando 3/12 da largura -->
                    <?= $form->field($model, 'price')->textInput([
                        'type' => 'number',
                        'step' => '0.01',
                        'class' => 'form-control w-100',
                        'placeholder' => 'Enter price'
                    ])->label(false) ?>
                </div>

                <!-- Coluna para o botão de submit -->
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
            'item.description',
            'price',
            [
                'attribute' => 'stock',
                'label' => 'Current Stock',
                'value' => function ($model) {
                    $userId = Yii::$app->user->id;

                    // Busca a estação associada ao usuário atual
                    $stationUser = \common\models\StationUser::findOne(['user_id' => $userId]);

                    if ($stationUser) {
                        $stationId = $stationUser->station_id;

                        // Agora busca o stock para o item e estação específicos
                        $itemStock = \common\models\ItemStock::findOne(['item_id' => $model->id, 'station_id' => $stationId]);

                        return $itemStock ? $itemStock->stock : 'No Stock Available';
                    }

                    return 'Station Not Assigned';
                },
            ],

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
                    'restock' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-archive"></i>',
                            ['item/delete-association', 'id' => $model->id],
                            [
                                'title' => 'Restock Item',
                                'data-method' => 'post',
                                'data-confirm' => 'Do you want to restock this item?',
                                'style' => 'color: #ffc107; text-decoration: none;',
                            ]
                        );
                    },
                    'restock' => function ($url, $model) {
                        return Html::a(
                            '<i class="fa fa-box"></i>',
                            ['item/restock', 'id' => $model->id], // URL para a action
                            [
                                'title' => 'Restock Item',
                                'data-confirm' => 'Do you want to restock this item?',
                                'data-method' => 'post',
                                'style' => 'color: #28a745; text-decoration: none;',
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