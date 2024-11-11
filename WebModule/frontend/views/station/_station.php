<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<style>
    .book-item {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .book-item .card-body {
        flex-grow: 1;
        border: 10px solid #000000;
        padding: 15px;
    }

    .star-button {
        font-size: 24px;
        color: #ffcc00;
        text-decoration: none;
    }

    .starred {
        color: #ffcc00;
    }

    .not-starred {
        color: #cccccc;
    }
</style>

<div class="card border-1 flex-fill">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h3><?= Html::a($model->name, ['station/view', 'id' => $model->id], ['style' => 'text-decoration: none; color: inherit;']) ?></h3>
                <p><i class="fa fa-location-dot"></i>&nbsp;<?= Html::encode($model->address) . ', ' . Html::encode($model->postal_code) ?></p>
                <p><i class="fa fa-user"></i>&nbsp;<?= Html::encode($model->manager->name) ?></p>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <?php
                $isFavorite = $model->isFavoritedByUser(Yii::$app->user->id);
                $starClass = $isFavorite ? 'starred' : 'not-starred';
                ?>
                <?= Html::a(
                    '<i class="fa fa-star ' . $starClass . '"></i>',
                    Url::to(['station/starred', 'station_id' => $model->id]),
                    [
                        'class' => 'star-button',
                        'title' => $isFavorite ? 'Remove Favourite' : 'Mark as Favourite',
                    ]
                ) ?>
            </div>
        </div>
    </div>
</div>