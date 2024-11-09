<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>
<nav class="main-header navbar navbar-expand navbar-white navbar-light fixed-top pd-5">
    <ul class="navbar-nav me-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <div class="container-fluid d-flex align-items-center">
        <?= Html::a(
            Html::img('@web/img/logo_nav_black.png', ['alt' => 'Logo', 'style' => 'height: 30px; width: auto;']),
            ['site/index'],
            ['class' => 'navbar-brand mx-auto d-flex align-items-center']
        ) ?>
    </div>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <?= Html::a('<i class="fas fa-sign-out-alt"></i>', ['/site/logout'], ['data-method' => 'post', 'class' => 'nav-link']) ?>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>