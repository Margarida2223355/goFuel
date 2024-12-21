<?php
    namespace app\modules\api\controllers;

    use common\models\Invoiceline;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;
    use yii\web\BadRequestHttpException;
    use yii\web\NotFoundHttpException;

    class InvoicelineController extends ActiveController {
        public $modelClass = Invoiceline::class;

        // Disable default action "index", "create"
        public function actions()
        {
            $actions = parent::actions();
            unset($actions['index'], $actions['create']);
            return $actions;
        }

        public function actionIndex() {
            $invoiceID = \Yii::$app -> request -> getHeaders() -> get('X-INVOICE-ID');

            if (!$invoiceID) {
                throw new NotFoundHttpException('No station ID provided');
            }

            $lines = Invoiceline::find()
                -> where(['invoice_id' => $invoiceID])
                -> with(['item', 'invoice.station', 'invoice.client'])
                -> asArray()
                -> all();

            return self::formatLineFields($lines);
        }

        public function actionCreate() {
            $request = \Yii::$app -> request -> bodyParams;
            $model = new Invoiceline();

            if ($model->load($request, '') && $model->save()) {
                return
                [
                    'message' => 'Success: New invoice line created!',
                ];
            }

            throw new BadRequestHttpException('Failed to create invoice line: ' . json_encode($model->errors));
        }

        public function actionUpdateline($id) {
            $model = Invoiceline::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('No invoice line found!');
            }

            $request = \Yii::$app -> request -> bodyParams;

            if ($model->load($request, '') && $model->save()) {
                return
                    [
                        'message' => 'Success: Invoice line updated!',
                    ];
            }

            throw new BadRequestHttpException('Failed to update invoice line: ' . json_encode($model->errors));
        }

        public function actionRemoveline($id) {
            $model = Invoiceline::findOne($id);

            if (!$model) {
                throw new NotFoundHttpException('No invoice line found!');
            }

            if($model->delete()) {
                return
                    [
                        'message' => 'Success: Invoice line removed!',
                    ];
            }

            throw new BadRequestHttpException('Failed to remove invoice line: ' . json_encode($model->errors));
        }

        private static function formatLineFields($data): array {
            return
                array_map(function ($line) {
                    $line = is_array($line) ? $line : $line->toArray();

                    $line['item'] = $line['item'];
                    $line['invoice'] = $line['invoice'];
                    unset($line['item_id'], $line['invoice_id']);

                    if (isset($line['item']['subcategory'])) {
                        $line['item']['subcategory'] = $line['item']['subcategory'];
                        unset ($line['item']['subcategory_id']);
                    }

                    if (isset($line['invoice']['station'])) {
                        $line['invoice']['station'] = $line['invoice']['station'];
                        unset($line['invoice']['station_id']);
                    }

                    if (isset($line['invoice']['client'])) {
                        $line['invoice']['client'] =  $line['invoice']['client'];
                        unset($line['invoice']['client_id']);
                    }

                    if (isset($line['invoice']['state'])) {
                        $line['invoice']['state'] =  $line['invoice']['state'];
                        unset($line['invoice']['state_id']);
                    }

                    return $line;
                }, $data);
        }
    }
?>
