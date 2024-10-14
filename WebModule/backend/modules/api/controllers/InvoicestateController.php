<?php
    namespace app\modules\api\controllers;

    use common\models\Invoicestate;
    use yii\rest\ActiveController;

    class InvoicestateController extends ActiveController {
        public $modelClass = Invoicestate::class;
    }
?>