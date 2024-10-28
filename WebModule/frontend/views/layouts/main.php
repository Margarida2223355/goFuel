<?php

/** @var \yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>

    <header>
        <?php
        $logoImage = Yii::$app->user->isGuest ? '@web/img/logo_nav.png' : '@web/img/logo_mini.png';

        NavBar::begin([
            'brandLabel' => Html::img($logoImage, [
                'data-bs-toggle' => 'tooltip',
                'title' => 'GoFuel',
                'style' => 'height: 40px; width: auto;',
            ]),
            'brandUrl' => ['site/index'],
            'options' => [
                'class' => 'navbar navbar-expand-lg bg-secondary navbar-dark fixed-top py-lg-0 px-lg-5',
                'data-wow-delay' => '0.1s',
            ],
        ]);

        // Itens de menu
        $menuItemsCenter = Yii::$app->user->isGuest ? [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'GII', 'url' => ['/gii']],
        ] : [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Service Areas', 'url' => ['#']],
            ['label' => 'Cart', 'url' => ['#']],
            ['label' => 'Profile', 'url' => ['/#']],
            ['label' => 'GII', 'url' => ['/gii']],
            ['label' => 'Contact', 'url' => ['/site/contact']],
        ];

        // Itens de autenticação à direita
        $menuItemsRight = Yii::$app->user->isGuest ? [
            ['label' => 'Login', 'url' => ['/site/login'], 'linkOptions' => ['style' => 'color: #0000EE;']],
            ['label' => 'Signup', 'url' => ['/site/signup'], 'linkOptions' => ['style' => 'color: #0000EE;']],
        ] : [
            ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['style' => 'color: #0000EE;', 'data-method' => 'post']],
        ];

        // Renderizar os itens do menu
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto p-4 p-lg-0'],
            'items' => $menuItemsCenter,
        ]);

        // Renderizar os itens de autenticação à direita
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav ms-auto p-4 p-lg-0'],
            'items' => $menuItemsRight,
        ]);

        NavBar::end();
        ?>
    </header>

    <main role="main" class="flex-shrink-0">
        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer class="footer mt-auto py-3 text-muted">
        <div class="container">
            <p class="float-center">&copy; <?= Html::encode(Yii::$app->name) ?> | David Domingues <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
