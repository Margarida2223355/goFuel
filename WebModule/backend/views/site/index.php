<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Homepage';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="container-fluid mt-5 ml-4">
    <div class="row">
        <?php if ($role): ?>
            <div class="col-lg-6">
                <h2><?= 'You are logged as ' . Html::encode($role) ?></h2>
                <?php if ($stationCount): ?>
                    <h4 class="ml-3">You are <?= Html::encode($role) ?> of <?= Html::encode($stationCount) ?> Stations</h4>
                <?php endif; ?>
                <?php if ($userRoleCounts): ?>
                    <h4 class="ml-3">User Count by Role</h4>
                    <?php foreach ($userRoleCounts as $name => $count): ?>
                        <h5 class="ml-5"><b><?= Html::encode($name) ?>:</b> <?= Html::encode($count) ?></h5>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($stationUserCounts)): ?>
            <div class="col-lg-6">
                <h2>Users Information</h2>
                <?php if ($role == "Admin"): ?>
                    <h4 class="ml-3">Users <sub style="font-size: 16px">(By stations)</sub></h4>
                <?php elseif ($role == 'Manager'): ?>
                    <h4 class="ml-3">Users <sub style="font-size: 16px">(By your stations)</sub></h4>
                <?php
                endif;
                foreach ($stationUserCounts as $stationName => $count): ?>
                    <h5 class="ml-5"><b><?= Html::encode($stationName) ?>:</b> <?= Html::encode($count) ?></h5>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if ($items): ?>
            <div class="col-lg-6">
                <?= GridView::widget([
                    'dataProvider' => $items,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'item.item.description',
                        'price',
                        // [
                        //     'attribute' => 'stock',
                        //     'label' => 'Current Stock',
                        //     'value' => function ($model) use ($item->station_Id) {
                        //         if ($stationId) {
                        //             $item = \common\models\StationItem::findOne(['item_id' => $model->id, 'station_id' => $stationId]);
                        //             return $item ? $item->stock : 'No Stock Available';
                        //         }
                        //         return 'Station Not Selected';
                        //     },
                        // ],
                    ],
                    'summary' => false,
                ]); ?>
            </div>
        <?php endif; ?>
    </div>
</div>