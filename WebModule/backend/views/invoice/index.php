<?php

use common\models\Invoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?>
    </p>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'client.userInfo.name',
            'station.name',
            'total',
            'state.description',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{finish} {view}', // Define os botões que podem aparecer
                'buttons' => [
                    'finish' => function ($url, $model, $key) {
                        // Só exibe o botão "Finish" se state_id for 2
                        if ($model->state_id == 2) {
                            return Html::a('<i class="fas fa-clipboard-check"></i>', ['invoice/finish', 'id' => $model->id], [
                                'title' => 'Finish',
                                'class' => 'action-icon'
                            ]);
                        }
                        return '';
                    },
                    'view' => function ($url, $model, $key) {
                        // Exibe o botão "View" para todos os estados, exceto quando state_id for 1
                        if ($model->state_id != 1) {
                            return Html::a('<i class="fas fa-eye"></i>', ['invoice/view', 'id' => $model->id], [
                                'title' => 'Ver',
                                'class' => 'action-icon'
                            ]);
                        }
                        return '';
                    },
                ],
                'urlCreator' => function ($action, $model, $key, $index) {
                    // Define a URL para cada ação (view e finish)
                    if ($action === 'view') {
                        return Url::to(['invoice/view', 'id' => $model->id]);
                    } elseif ($action === 'finish') {
                        return Url::to(['invoice/finish', 'id' => $model->id]);
                    }
                    return '#';
                },
            ],
        ],
        'summary' => false,
    ]); ?>



</div>