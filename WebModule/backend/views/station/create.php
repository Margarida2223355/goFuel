<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Station */
/* @var $managersList array */

$this->title = 'Create Station';
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="station-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'managersList' => $managersList,  // Passa a lista de managers para o formulário
    ]) ?>

</div>