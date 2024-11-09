<?php

use yii\helpers\Url;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column justify-content-center">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
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
                    ['label' => 'Invoices', 'icon' => 'file', 'url' => ['/invoice/index']],
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
    /* Centraliza o conteúdo da sidebar verticalmente */
    .sidebar {
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Mudando o fundo do link ativo na sidebar */
    .sidebar .nav-link.active {
        background-color: #FEC454;
        /* A cor que você deseja para o fundo do link ativo */
        color: #ffffff;
        /* Cor do texto do link ativo */
    }

    /* Caso queira mudar a cor do link não ativo */
    .sidebar .nav-link {
        color: #333333;
        /* Cor do texto para links não ativos */
    }

    /* Se quiser alterar a cor do texto quando o item estiver no hover */
    .sidebar .nav-link:hover {
        background-color: #FEC454;
        /* Cor de fundo no hover */
        color: #ffffff;
        /* Cor do texto no hover */
    }
</style>