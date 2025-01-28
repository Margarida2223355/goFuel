<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\StationItem;

/** @var yii\web\View $this */
/** @var common\models\Invoice $model */

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?= Yii::$app->getUrlManager()->getBaseUrl() ?>/img/logo_mini.png" type="image/x-icon">
    <title>Invoice <?= Html::encode($model->generateFinalCode()) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }

        p {
            margin: 5px 0;
        }

        .header,
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        .actions {
            text-align: center;
        }

        .btn {
            display: inline-block;
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            margin: 0 5px;
            border-radius: 4px;
        }

        .btn-warning {
            background-color: #f0ad4e;
        }

        .btn-danger {
            background-color: #d9534f;
        }

        .btn-success {
            background-color: #5cb85c;
        }

        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Invoice <?= Html::encode($model->generateFinalCode()) ?></h1>

        <div class="row">
            <div class="col">
                <p><b>Station:</b> <?= Html::encode($model->station->name) ?></p>
                <p><b>Client:</b> <?= Html::encode($model->client->userInfo->name) ?></p>
                <p><b>State:</b> <?= Html::encode($model->state->description) ?></p>
            </div>
            <div class="col">
                <p><b>Date:</b> <?= Html::encode($model->invoice_date) ?></p>
                <p><b>Total Price:</b> <?= Html::encode($model->total . ' €') ?></p>
                <?php if ($model->state_id == 2): ?>
                    <p><b>Code:</b> <?= Html::encode($model->code) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Unit Price (€)</th>
                    <th>Quantity</th>
                    <th>Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($model->invoiceLines): ?>
                    <?php foreach ($model->invoiceLines as $line):
                        $stationItem = StationItem::findOne(['item_id' => $line->item_id, 'station_id' => $model->station_id]); ?>
                        <tr>
                            <td><?= Html::encode($line->item->description) ?></td>
                            <td><?= Html::encode($stationItem->price) ?></td>
                            <td><?= Html::encode(round($line->qty, 2)) ?></td>
                            <td><?= Html::encode($line->total) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" style="text-align: center;">No invoice lines available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p><?= Html::encode(Yii::$app->name) ?> | <?= date('Y/m/d H:i') ?></p>
    </div>
</body>

</html>