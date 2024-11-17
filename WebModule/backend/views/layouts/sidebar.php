<?php

use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed nav-legacy">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-center">
        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    /*['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],*/
                    ['label' => 'Homepage', 'icon' => 'home', 'url' => ['/site/index']],
                    ['label' => 'Users', 'icon' => 'users', 'url' => ['user/index']],
                    ['label' => 'Stations', 'icon' => 'building', 'url' => ['/station/index']],
                    ['label' => 'Categories', 'icon' => 'tags', 'url' => ['/category/index']],
                    ['label' => 'Items', 'icon' => 'box', 'url' => ['/item/index']],
                    ['label' => 'Invoices', 'icon' => 'file-lines', 'url' => ['/invoice/index']],
                ],
            ]);

            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => Yii::$app->user->identity->userInfo->name, 'icon' => 'user', 'url' => ['/user/update', 'id' => Yii::$app->user->identity->id]],
                ],
            ]);
            ?>
        </nav>
    </div>
</aside>

<style>
    .sidebar {
        height: 100vh;
        display: flex;
        justify-content: center;
    }

    .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active,
    .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
        background-color: #FEC454 !important;
        color: #000 !important;
    }
</style>