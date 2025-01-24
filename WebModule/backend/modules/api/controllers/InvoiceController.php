<?php
    namespace app\modules\api\controllers;

    use common\models\Invoice;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;
    use yii\web\BadRequestHttpException;
    use yii\web\NotFoundHttpException;

    class InvoiceController extends ActiveController {
        public $modelClass = Invoice::class;

        public function actionCreateinvoice() {
            $model = new Invoice();
            $request = \Yii::$app -> request -> bodyParams;

            if ($model -> load($request, '') && $model -> save()) {
                $model->generateRandomCode();
                return self::formatInvoiceFields($model);
            }

            throw new BadRequestHttpException('Failed to create invoice: ' . json_encode($model->errors));
        }

        public function actionGetUserInvoices() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            $invoices = Invoice::find()
                -> where(['client_id' => $userID])
                -> with(['station', 'state', 'client'])
                -> asArray()
                -> all();

            return self::formatInvoiceFields($invoices);
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
                ->where([
                    'client_id' => $userID,
                    'invoice_states.description' => 'Pending'
                    ])
                ->all();
        }

        public function actionGetCartInvoices() {
            $userID = \Yii::$app -> request -> getHeaders() -> get('X-USER-ID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            return Invoice::find()
                ->joinWith('state')
                ->where([
                    'client_id' => $userID,
                    'invoice_states.description' => 'Cart'
                    ])
                ->all();
        }

        public function actionGetPendentStationInvoices() {
            $userID = \Yii::$app->request->getBodyParam('userID');
            $stationID = \Yii::$app->request->getBodyParam('stationID');

            if (!$userID) {
                throw new UnauthorizedHttpException('No user ID provided');
            }

            if (!$stationID) {
                throw new UnauthorizedHttpException('No station ID provided');
            }

            return Invoice::find()
                ->joinWith('state')
                ->where([
                    'client_id' => $userID,
                    'station_id' => $stationID,
                    'invoice_states.description' => 'Cart'
                    ])
                ->all();
        }

        public function actionUpdateinvoice($id) {
            $model = Invoice::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('Invoice not found');
            }

            $model->state_id = 2; // Pending
            $model->generateFinaCode();

            if ($model->save()) {

                return 'Success: Invoice closed!';
            }

            return 'Failed to remove invoice line: ' . json_encode($model->errors);

        }

        private static function formatInvoiceFields($data): array {
            if ($data instanceof Invoice) {
                $data = [$data -> toArray()];
            }
            return
                array_map(function ($invoice) {

                    $invoice['client'] = $invoice['client'];
                    $invoice['station'] = $invoice['station'];
                    $invoice['state'] = $invoice['state'];

                    unset($invoice['client_id'], $invoice['station_id'], $invoice['state_id']);
                    return $invoice;
                }, $data);
        }
    }
?>