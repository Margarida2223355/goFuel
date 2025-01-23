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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="icon" href="<?= Yii::getAlias('@web') ?>/img/logo_mini.png" type="image/x-icon">
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

        // Menu items
        $menuItems = Yii::$app->user->isGuest ? [
            ['label' => 'Home', 'url' => ['/site/index']],
            //['label' => 'About', 'url' => ['/site/about']],
            ['label' => 'Service Areas', 'url' => ['/station/index']],
        ] : [
            ['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Service Areas', 'url' => ['/station/index']],
            ['label' => 'Cart', 'url' => ['/invoice/index-cart']],
            ['label' => 'All Invoices', 'url' => ['/invoice/index']],
            ['label' => 'Profile', 'url' => ['/site/profile']],
        ];

        // Right items
        $menuItemsRight = Yii::$app->user->isGuest ? [
            ['label' => 'Login', 'url' => ['/site/login'], 'linkOptions' => ['style' => 'color: #0000EE;']],
            ['label' => 'Signup', 'url' => ['/site/signup'], 'linkOptions' => ['style' => 'color: #0000EE;']],
        ] : [
            ['label' => 'Logout (' . Yii::$app->user->identity->userInfo->name . ')', 'url' => ['/site/logout'], 'linkOptions' => ['style' => 'color: #0000EE;', 'data-method' => 'post']],
        ];

        // Render items on nav
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav me-auto p-4 p-lg-0'],
            'items' => $menuItems,
        ]);

        // Auth items
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
            <p class="float-center">&copy; <?= Html::encode(Yii::$app->name) ?> | David Domingues & Margarida Camacho <?= date('Y') ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
