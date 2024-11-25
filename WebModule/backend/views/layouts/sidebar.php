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

                    /*Yii::$app->user->can('StationIndex') ? */
                    ['label' => 'Stations', 'icon' => 'building', 'url' => ['/station/index']], /*: null*/

                    ['label' => 'Categories', 'icon' => 'tags', 'url' => ['/category/index']],
                    ['label' => 'Items', 'icon' => 'box', 'url' => ['/item/index']],
                    ['label' => 'Invoices', 'icon' => 'file-lines', 'url' => ['/invoice/index']],
                ],
            ]);

            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Profile (' . Yii::$app->user->identity->userInfo->name . ')', 'icon' => 'user', 'url' => ['/user/update', 'id' => Yii::$app->user->identity->id]],
                ],
            ]);
            ?>
        </nav>
    </div>
</aside>