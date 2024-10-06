<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'nif',
            'address',
            'postal_code',
            'role',
            [
                'label' => 'Username', // Aqui usamos a relação com User
                'value' => $model->user->username, // Acessando o username do User
            ],
            [
                'label' => 'Email',
                'value' => $model->user->email, // Acessando o email do User
            ],
            [
                'label' => 'Status',
                'value' => $model->user->status == 10 ? 'Active' : 'Inactive', // Exemplo de mapeamento de status
            ],
            // Outras informações que você quiser mostrar do user_info
        ],
    ]) ?>

</div>