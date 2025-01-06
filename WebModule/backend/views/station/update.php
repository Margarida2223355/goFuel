<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Station */
/* @var $managersList array */

$this->title = 'Update Station: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'isUpdate' => $isUpdate,
        'managersList' => $managersList,
        'currentPumpsCount' => $currentPumpsCount,
    ]) ?>

</div>