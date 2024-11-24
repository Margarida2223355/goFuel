<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container-fluid ml-1">

    <?= $this->render('_form', [
        'model' => $model, // Passa o modelo para a view _form
    ]) ?>

</div>