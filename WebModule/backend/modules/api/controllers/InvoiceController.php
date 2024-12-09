<?php
    namespace app\modules\api\controllers;

    use common\models\Invoice;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;
    use yii\web\BadRequestHttpException;
    use yii\web\NotFoundHttpException;

    class InvoiceController extends ActiveController {
        public $modelClass = Invoice::class;

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
                ->where(['client_id' => $userID, 'invoice_states.description' => 'Pending'])
                ->all();
        }

        public function actionUpdateinvoice($id) {
            $model = Invoice::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('Invoice not found');
            }

            $request = \Yii::$app -> request -> bodyParams;

            if ($model->load($request, '') && ($model->save())) {
                $model->generateRandomCode();

                return
                    [
                        'message' => 'Success: Invoice closed!',
                    ];
            }

            throw new BadRequestHttpException('Failed to remove invoice line: ' . json_encode($model->errors));
        }

        private static function formatInvoiceFields($data): array {
            return
                array_map(function ($invoice) {
                    $invoice = is_array($invoice) ? $invoice : $invoice->toArray();

                    $invoice['client'] = $invoice['client'];
                    $invoice['station'] = $invoice['station'];
                    $invoice['state'] = $invoice['state'];

                    unset($invoice['item_id'], $invoice['invoice_id'], $invoice['state_id']);
                    return $invoice;
                }, $data);
        }
    }
?>