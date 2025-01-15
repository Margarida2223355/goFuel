<?php

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Homepage';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<h1><?= Html::encode($this->title) ?></h1>
<div class="container-fluid mt-5">
    <div class="row">
        <?php
        switch ($role) {
            case 'Admin':
        ?>
                <div class="col-12">
                    <h3>Users Information</h3>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of users',
                        'number' => $usersCount,
                        'theme' => 'success',
                        'icon' => 'fa fa-users',
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Admins',
                        'body' => $userRoleCounts['Admin'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Managers',
                        'body' => $userRoleCounts['Manager'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'In charges',
                        'body' => $userRoleCounts['Incharge'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Employees',
                        'body' => $userRoleCounts['Employee'],
                    ]) ?>
                </div>
                <div class="col-2">
                    <?= \hail812\adminlte\widgets\Callout::widget([
                        'type' => 'success',
                        'head' => 'Clients',
                        'body' => $userRoleCounts['Client'],
                    ]) ?>
                </div>
                <div class="col-6">
                    <h3>Stations Information</h3><br>
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of stations',
                        'number' => $stationCount,
                        'theme' => 'info',
                        'icon' => 'fa fa-building',
                    ]) ?>
                </div>
                <div class="col-6"></div>
                <div class="col-6">
                    <h3>Invoices Information</h3><br>
                    <?= \hail812\adminlte\widgets\InfoBox::widget([
                        'text' => 'Total of Invoices',
                        'number' => $invoiceCount,
                        'theme' => 'info',
                        'icon' => 'fa fa-file-lines',
                    ]) ?>
                </div>
                <div class="col-6"></div>
                <?php
                foreach ($stations as $station) {
                    $invoiceCount = isset($invoiceByStation[$station->id]) ? $invoiceByStation[$station->id] : 0;
                ?>
                    <div class="col-md-4 col-md-3 col-sm-6 col-12">
                        <?= \hail812\adminlte\widgets\Callout::widget([
                            'type' => 'success',
                            'head' => $station->name,
                            'body' => "Number of invoices: " . $invoiceCount,
                        ]) ?>
                    </div>
                <?php
                }
                ?>
            <?php
                break;
            case 'Manager':
            ?>
                <?php
                foreach ($stations as $station) {
                    $inchargeCount = $stationUserCounts[$station->name]['incharges'] ?? 0;
                    $employeeCount = $stationUserCounts[$station->name]['employees'] ?? 0;
                    $invoiceCount = $stationInvoiceCounts[$station->name] ?? 0;
                ?>
                    <div class="col-3">
                        <?= \hail812\adminlte\widgets\Callout::widget([
                            'type' => 'info',
                            'head' => $station->name,
                            'body' => "Incharges: $inchargeCount<br>Employees: $employeeCount<br>Invoices: $invoiceCount",
                        ]) ?>
                    </div>
                <?php
                }
                ?>
                <?php
                break;
                ?>


        <?php } ?>
    </div>
</div>