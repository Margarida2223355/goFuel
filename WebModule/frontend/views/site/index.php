<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = Yii::$app->name . ' | HomePage';
?>
<div class="site-index">

    <h1 class="d-inline-block  py-1 justify-content-center"><?= 'HomePage' ?></h1>

    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5 justify-content-center">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h2 class="text-uppercase mb-3">Your favourite station</h2>
                    <div class="col-md-10">
                        <?php if ($station != null) { ?>
                            <h3><?= Html::a($station->name, ['station/view', 'id' => $station->id], ['style' => 'text-decoration: none; color: inherit;']) ?></h3>
                            <p><i class="fa fa-location-dot"></i>&nbsp;<?= Html::encode($station->address) . ', ' . Html::encode($station->postal_code) ?></p>
                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <?= Html::a(
                                        'Call Station',
                                        'tel:' . Html::encode($station->phone),
                                        ['class' => 'btn btn-warning me-2']
                                    ) ?>
                                </div>
                                <div class="col-md-6">
                                    <?= Html::a(
                                        'View Station',
                                        Url::to(['station/view', 'id' => $station->id]),
                                        ['class' => 'btn btn-warning me-2']
                                    ) ?>
                                </div>

                            </div>
                        <?php } else { ?>
                            <h3>You dont have a favourite station</h3>
                        <?php } ?>

                    </div>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <h2 class="text-uppercase mb-3">Your Orders</h2>
                    <div class="col-md-10">
                        <?php if ($invoices != null) { ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Invoice Date</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($invoices as $invoice) { ?>
                                        <tr>
                                            <td><?php echo $invoice->id; ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($invoice->invoice_date)); ?></td>
                                            <td><?php echo number_format($invoice->total, 2); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } else { ?>
                            <h3>You dont have orders</h3>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>