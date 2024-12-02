<?php
/* @var $content string */

use hail812\adminlte\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
?>
<div class="content-wrapper pt-5">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <?php
                echo Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    'options' => [
                        'class' => 'breadcrumb float-sm-right'
                    ]
                ]);
                ?>
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
                        if (!is_null($this->title)) {
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>