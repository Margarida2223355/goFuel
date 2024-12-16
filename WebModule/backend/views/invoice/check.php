<?php

use hail812\adminlte\widgets\Alert;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */

$this->title = Yii::$app->name . ' | Check Invoice';
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Check Invoice';
\yii\web\YiiAsset::register($this);
?>
<?php
$alert = Yii::$app->session->get('alert');
if ($alert != null) {
    echo Alert::widget([
        'type' => $alert['type'],
        'body' => "<strong>{$alert['title']}</strong><br> {$alert['message']}",
    ]);
}
Yii::$app->session->remove('alert');
?>
<div class="container-fluid ml-1">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'client.userInfo.name',
            'station.name',
            'total',
            'state.description',
        ],
    ]) ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Verify', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>