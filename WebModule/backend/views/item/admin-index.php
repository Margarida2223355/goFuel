<?php

use hail812\adminlte\widgets\Alert;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Items Management';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$alert = Yii::$app->session->get('alert');
if ($alert != null) {
    echo Alert::widget([
        'type' => $alert['type'],
        'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
    ]);
}
Yii::$app->session->remove('alert');
?>
<div class="container-fluid ml-1">

    <div class="d-flex align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
        'subcategories' => $subcategories,
        'isUpdate' => $isUpdate
    ]) ?>

    <div class="row">
        <div class="col-6 float-left">
            <h6>
                <i class="fa-regular fa-circle-check" style="color: #28a745;"></i> - Enabled Item &emsp;
                <i class="fa-regular fa-circle-xmark" style="color: #dc3545;"></i> - Disabled Item
            </h6>
        </div>
        <div class="col-6 float-right">
            <h6 class="float-right">
                <i class="fa fa-pen" style="color: #28a745;"></i> - Edit Item &emsp;
                <i class="fa fa-redo" style="color: #ffcc00;"></i> - Enable Item &emsp;
                <i class="fa fa-trash" style="color: #dc3545;"></i> - Desable Item
            </h6>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'description',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->is_deleted
                        ? Html::tag('i', '', ['class' => 'fa-regular fa-circle-xmark', 'aria-hidden' => 'true', 'style' => 'color: #dc3545']) . ' ' . $model->description
                        : Html::tag('i', '', ['class' => 'fa-regular fa-circle-check', 'aria-hidden' => 'true', 'style' => 'color: #28a745']) . ' ' . $model->description;
                },
            ],
            [
                'label' => 'Category - Subcategory',
                'attribute' => 'category_subcategory',
                'value' => function ($model) {
                    if ($model->subcategory->is_deleted == 0) {
                        return $model->subcategory ? $model->subcategory->category->name . ' - ' . $model->subcategory->description : 'N/A';
                    } else {
                        return 'Category/Subcategory deleted. Please change.';
                    }
                },
            ],
            'restock_qty',
            [
                'class' => ActionColumn::class,
                'header' => 'Actions',
                'template' => '{update} {delete}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', $url, [
                            'title' => 'Update',
                            'style' => 'color: #28a745; text-decoration: none;',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        if ($model->is_deleted == false) {
                            return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                                'title' => 'Desable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Item Disablement?',
                                'style' => 'color: #dc3545; text-decoration: none;',
                            ]);
                        } else {
                            return Html::a('<i class="fa fa-redo" aria-hidden="true"></i>', $url, [
                                'title' => 'Enable',
                                'data-method' => 'post',
                                'data-confirm' => 'Confirm Item Enablement?',
                                'style' => 'color: #ffcc00; text-decoration: none;',
                            ]);
                        }
                    },
                ],
            ],
        ],
        'summary' => false,
    ]); ?>

</div>