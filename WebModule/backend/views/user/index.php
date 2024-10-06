<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            'id', // ID do User
            'username', // Username do User
            [
                'label' => 'Nome', // Nome do UserInfo
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->name : 'N/A'; // Acessando o campo Nome de UserInfo
                },
            ],
            'email', // Email do User
            [
                'label' => 'Phone', // NIF do UserInfo
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->phone : 'N/A'; // Acessando o campo NIF de UserInfo
                },
            ],
            [
                'label' => 'Role', // Role do UserInfo
                'value' => function ($model) {
                    return $model->userInfo ? $model->userInfo->role : 'N/A'; // Acessando o campo Role de UserInfo
                },
            ],

            [
                'class' => ActionColumn::class,
                'template' => '{view} {update} {delete} {reset-password}',
                'buttons' => [
                    'reset-password' => function ($url, $model) {
                        return Html::a('<i class="fa fa-lock" aria-hidden="true"></i>', $url, [
                            'title' => 'Resetar Senha',
                            'data-method' => 'post',
                            'data-confirm' => 'Tem certeza que deseja redefinir a senha para o padrão?',
                            'style' => 'color: #ffcc00; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-eye" aria-hidden="true"></i>', $url, [
                            'title' => 'Visualizar',
                            'style' => 'color: #007bff; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-pens" aria-hidden="true"></i>', $url, [
                            'title' => 'Atualizar',
                            'style' => 'color: #28a745; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('<i class="fa fa-trash" aria-hidden="true"></i>', $url, [
                            'title' => 'Deletar',
                            'data-method' => 'post',
                            'data-confirm' => 'Tem certeza que deseja deletar este usuário?',
                            'style' => 'color: #dc3545; text-decoration: none;', // Estilo opcional
                        ]);
                    },
                ],
            ],


        ],
    ]); ?>
</div>