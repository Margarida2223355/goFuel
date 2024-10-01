<?php
    namespace app\modules\api\controllers;

    use common\models\Invoice;
    use yii\rest\ActiveController;

    class InvoiceController extends ActiveController {
        public $modelClass = Invoice::class;
    }
?>