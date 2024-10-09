<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <div style="display: flex; align-items: center; ">
        <h1><?= Html::encode($this->title . ' - ' . $role) ?></h1>
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
            'name',
            'nif',
            'address',
            'postal_code',
            [
                'label' => 'Username', // Aqui usamos a relação com User
                'value' => $model->user->username, // Acessando o username do User
            ],
            [
                'label' => 'Email',
                'value' => $model->user->email, // Acessando o email do User
            ],
            // Outras informações que você quiser mostrar do user_info
        ],
    ]) ?>

</div>