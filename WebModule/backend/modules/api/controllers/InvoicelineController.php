<?php
    namespace app\modules\api\controllers;

    use common\models\Invoiceline;
    use yii\rest\ActiveController;

    class InvoicelineController extends ActiveController {
        public $modelClass = Invoiceline::class;
    }
?>