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
            'allModels' => $model->stationItems,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            [
                'label' => 'Item Name',
                'value' => function ($stationItem) {
                    return $stationItem->item->description;
                },
            ],
            [
                'label' => 'Price',
                'value' => function ($stationItem) {
                    return Yii::$app->formatter->asCurrency($stationItem->price, 'EUR');
                },
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Add to Cart',
                'template' => '{add-to-cart}',
                'buttons' => [
                    'add-to-cart' => function ($url, $stationItem, $key) {
                        return Html::beginForm(['invoice/addtocart', 'id' => $stationItem->id], 'post', [
                            'style' => 'display: inline-flex; align-items: center;'
                        ]) .
                            Html::input('number', 'quantity', 1, [
                                'class' => 'form-control',
                                'style' => 'width: 100px; margin-right: 5px;',
                                'min' => 1,
                                'title' => 'Quantidade'
                            ]) .
                            Html::submitButton('<i class="fa fa-shopping-cart"></i>', [
                                'class' => 'btn btn-sm',
                                'style' => 'color: #FFD100; text-decoration: none;',
                                'data-confirm' => 'Do you want to add this item to your cart?',
                                'title' => 'Add to Cart',
                            ]) .
                            Html::endForm();
                    },
                ],
            ],
        ],
    ]) ?>
</div>