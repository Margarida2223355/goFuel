<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tarefa $model */

$this->title = 'Create Tarefa';
$this->params['breadcrumbs'][] = ['label' => 'Tarefas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tarefa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'user_id' => $user_id
    ]) ?>

</div>
