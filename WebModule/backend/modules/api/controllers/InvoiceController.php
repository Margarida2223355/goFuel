<?php
    namespace app\modules\api\controllers;

    use common\models\Invoice;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;

    class InvoiceController extends ActiveController {
        public $modelClass = Invoice::class;

        public function actionGetUserInvoices() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            return Invoice::find() -> where(['client_id' => $userID]) -> all();
        }

        public function actionGetPaidInvoices() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            return Invoice::find()
                ->joinWith('state')
                ->where(['client_id' => $userID, 'invoice_states.description' => 'Finished'])
                ->all();
        }

        public function actionGetPendentInvoices() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            return Invoice::find()
                ->joinWith('state')
                ->where(['client_id' => $userID, 'invoice_states.description' => 'Pending'])
                ->all();
        }
    }
?>