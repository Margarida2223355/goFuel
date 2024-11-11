<?php

use common\models\Station;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::$app->name . ' | ' . 'Stations';
$this->params['breadcrumbs'][] = 'Stations';
?>
<div class="station-index">

    <h1><?= Html::encode('Stations') ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_station',
        'options' => [
            'class' => 'row', // Adiciona a classe "row" ao contêiner da ListView
        ],
        'itemOptions' => [
            'class' => 'col-md-4', // Cada item ocupará 1/3 da tela em telas médias e maiores
        ],
        'summary' => false,
    ]); ?>


</div>