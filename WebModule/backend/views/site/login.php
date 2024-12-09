<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use hail812\adminlte\widgets\Alert;
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="align-items-center justify-content-center py-5">
    <?php
    $alert = Yii::$app->session->get('alert');
    if ($alert) {
        echo Alert::widget([
            'options' => ['class' => 'alert-danger'],
            'body' => "<strong>{$alert['title']}</strong> {$alert['message']}",
        ]);
        Yii::$app->session->remove('alert');
    }
    ?>
</div>
<div class="site-login d-flex align-items-center justify-content-center" style="min-height: 50vh;">


    <div class="row justify-content-center">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <!-- <div class="my-1 mx-0" style="color:#999;">
                If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
                <br>
                Need new verification email? <?= Html::a('Resend', ['site/resend-verification-email']) ?>
            </div> -->

            <div class="form-group">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>