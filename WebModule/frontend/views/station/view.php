<?php

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Station $model */

$this->title = Yii::$app->name . ' | ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="station-view">

    <h1><?= Html::encode($model->name) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'address',
            'postal_code',
            'manager.name',
        ],
    ]) ?>

    <h3>Available Items</h3>

    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $model->stationItems, // Usa stationItems em vez de items diretamente
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            [
                'label' => 'Item Name',
                'value' => function ($stationItem) {
                    return $stationItem->item->description; // Acessa o nome do item relacionado
                },
            ],
            [
                'label' => 'Price',
                'value' => function ($stationItem) {
                    return Yii::$app->formatter->asCurrency($stationItem->price); // Acessa o preço na tabela intermediária
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{add-to-cart}',
                'buttons' => [
                    'add-to-cart' => function ($url, $stationItem, $key) {
                        return Html::a('<i class="fa fa-shopping-cart"></i>', ['station/add-to-cart', 'item_id' => $stationItem->item_id], [
                            'class' => 'btn btn-sm',
                            'style' => 'color: #FFD100; text-decoration: none;',
                            'data-method' => 'post',
                            'data-confirm' => 'Do you want to add this item to your cart?',
                            'title' => 'Add to Cart',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>