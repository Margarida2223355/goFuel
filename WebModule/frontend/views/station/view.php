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
            'manager.userInfo.name',
        ],
    ]) ?><?php
            // Recebendo as variáveis de filtro dos parâmetros GET
            $filterCategory = Yii::$app->request->get('filterCategory', null);
            $filterSubcategory = Yii::$app->request->get('filterSubcategory', null);

            // Obtendo as categorias e subcategorias para as dropdowns
            $categories = \common\models\Category::find()->all(); // Ajuste o namespace e o modelo conforme necessário
            $subcategories = !empty($filterCategory)
                ? \common\models\Subcategory::find()->where(['category_id' => $filterCategory])->all()
                : \common\models\Subcategory::find()->all()
            ?>

    <h3>Available Items</h3>

    <!-- Dropdowns de filtro -->
    <div class="row">
        <div class="col-md-6">
            <?= Html::beginForm(['station/view', 'id' => $model->id], 'get', ['class' => 'form-inline']) ?>

            <div class="row">
                <!-- Dropdown de Categorias -->
                <div class="col-md-6">
                    <?= Html::dropDownList(
                        'filterCategory',
                        $filterCategory,
                        \yii\helpers\ArrayHelper::map($categories, 'id', 'name'),
                        [
                            'prompt' => 'All Categories',
                            'class' => 'form-control',
                            'onchange' => 'this.form.submit()' // Submete o formulário automaticamente ao mudar o valor
                        ]
                    ) ?>
                </div>
                <!-- Dropdown de Subcategorias -->
                <div class="col-md-6">
                    <?= Html::dropDownList(
                        'filterSubcategory',
                        $filterSubcategory,
                        \yii\helpers\ArrayHelper::map($subcategories, 'id', 'description'),
                        [
                            'prompt' => 'All Subcategories',
                            'class' => 'form-control',
                            'onchange' => 'this.form.submit()' // Submete o formulário automaticamente ao mudar o valor
                        ]
                    ) ?>
                </div>
            </div>

            <?= Html::endForm() ?>
        </div>
    </div>
    <br>
    <!-- GridView -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'label' => 'Item Name',
                'value' => function ($stationItem) {
                    return $stationItem->item->description;
                },
            ],
            [
                'label' => 'Category',
                'value' => function ($stationItem) {
                    return $stationItem->item->subcategory->category->name;
                },
            ],
            [
                'label' => 'Subcategory',
                'value' => function ($stationItem) {
                    return $stationItem->item->subcategory->description;
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
                        return Html::beginForm(['invoice/addtocart', 'item_id' => $stationItem->item_id, 'station_id' => $stationItem->station_id], 'post', [
                            'style' => 'display: inline-flex; align-items: center;'
                        ]) .
                            ($stationItem->item->subcategory->category->id == 1 || $stationItem->item->subcategory->category->id == 2
                                ? Html::input('number', 'quantity', 1, [
                                    'class' => 'form-control',
                                    'style' => 'width: 100px; margin-right: 5px;',
                                    'min' => 0.1,
                                    'step' => 0.1,
                                    'title' => 'Quantidade (decimais permitidos)',
                                ])
                                : Html::input('number', 'quantity', 1, [
                                    'class' => 'form-control',
                                    'style' => 'width: 100px; margin-right: 5px;',
                                    'min' => 1,
                                    'step' => 1,
                                    'title' => 'Quantidade (apenas inteiros)',
                                ])
                            ) .
                            Html::submitButton('<i class="fa fa-shopping-cart"></i>', [
                                'class' => 'btn btn-sm',
                                'style' => 'color: #FFD100; text-decoration: none;',
                                //'data-confirm' => 'Do you want to add this item to your cart?',
                                'title' => 'Add to Cart',
                            ]) .
                            Html::endForm();
                    },
                ],
            ],
        ],
        'summary' => false,
    ]) ?>



</div>