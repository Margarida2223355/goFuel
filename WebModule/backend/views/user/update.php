<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="user-update">

    <?= $this->render('_form', [
        'model' => $model, // Passa o modelo para a view _form
    ]) ?>

</div>