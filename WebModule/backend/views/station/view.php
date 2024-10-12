<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $station common\models\Station */

$this->title = $station->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="station-view">

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', ['update', 'id' => $station->id], [
                'title' => 'Atualizar',
                'style' => 'color: #28a745; text-decoration: none; margin-right: 10px; margin-left: 15px;',
            ]) ?>
            <?php if (Yii::$app->user->can('admin')): ?>
                <?= Html::a('Delete', ['delete', 'id' => $station->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this station?',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $station,
        'attributes' => [
            'id',
            'name',
            'address',
            'postal_code',
            [
                'label' => 'Manager',
                'value' => $station->manager->name, // Supondo que o manager tenha uma relação 'name' ou 'username'
            ],
        ],
    ]) ?>

</div>