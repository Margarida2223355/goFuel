<?php

use common\models\Station;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->userInfo->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid ml-1">

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?php
            if ($model->id === Yii::$app->user->identity->id) {
                echo Html::a('<i class="fa fa-pen" aria-hidden="true"></i>', ['update', 'id' => $model->id], [
                    'title' => 'Atualizar',
                    'style' => 'color: #28a745; text-decoration: none; margin-right: 10px; margin-left: 15px;',
                ]);
            } else {
                echo Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', ['delete', 'id' => $model->id], [
                    'title' => 'Deletar',
                    'data-method' => 'post',
                    'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                    'style' => 'color: #dc3545; text-decoration: none; margin-right: 10px; margin-left: 15px;',
                ]);
            } ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userInfo.name',
            'userInfo.nif',
            'userInfo.phone',
            'userInfo.address',
            'userInfo.postal_code',
            [
                'label' => 'Station Name',
                'value' => function ($model) {
                    $userRole = Yii::$app->authManager->getRolesByUser($model->id);

                    if (isset($userRole['Admin'])) {
                        return null;
                    } elseif (isset($userRole['Manager'])) {
                        $stations = Station::find()
                            ->where(['manager_id' => $model->id])
                            ->all();

                        return $stations ? implode(' | ', array_column($stations, 'name')) : 'N/A';
                    } else {
                        return $model->stationUsers ? $model->stationUsers->station->name : 'N/A';
                    }
                },
            ],
            [
                'label' => 'Username',
                'value' => $model->username,
            ],
            [
                'label' => 'Email',
                'value' => $model->email,
            ],
        ],
    ]) ?>

</div>