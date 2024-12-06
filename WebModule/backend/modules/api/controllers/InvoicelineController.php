<?php
    namespace app\modules\api\controllers;

    use common\models\Invoiceline;
    use yii\rest\ActiveController;

    class InvoicelineController extends ActiveController {
        public $modelClass = Invoiceline::class;

        // Disable default action "index"
        public function actions()
        {
            $actions = parent::actions();
            unset($actions['index']);
            return $actions;
        }

        public function actionIndex() {
            $invoiceID = \Yii::$app -> request -> getHeaders() -> get('X-INVOICE-ID');

            if (!$invoiceID) {
                throw new UnauthorizedHttpException('No station ID provided');
            }

            return Invoiceline::find()
                ->where(['invoice_id' => $invoiceID])
                ->all();
        }
    }
?>