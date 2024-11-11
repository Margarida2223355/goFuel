<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Item $model */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => 'Items', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="item-view">

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', ['update', 'id' => $model->id], [
                'title' => 'Atualizar',
                'style' => 'color: #28a745; text-decoration: none; margin-right: 10px; margin-left: 15px;',
            ]) ?>
            <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $model->id], [
                'title' => 'Deletar',
                'data-method' => 'post',
                'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                'style' => 'color: #dc3545; text-decoration: none;',
            ]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'description',
            'price',
            'subcategory_id',
        ],
    ]) ?>

</div>