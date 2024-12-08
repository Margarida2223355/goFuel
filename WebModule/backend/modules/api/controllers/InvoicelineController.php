<?php
    namespace app\modules\api\controllers;

    use common\models\Invoiceline;
    use yii\rest\ActiveController;
    use yii\web\UnauthorizedHttpException;

    class InvoicelineController extends ActiveController {
        public $modelClass = Invoiceline::class;

        // Disable default action "index"
        public function actions()
        {
            $actions = parent::actions();
            unset($actions['index'], $actions['create']);
            return $actions;
        }

        public function actionIndex() {
            $invoiceID = \Yii::$app -> request -> getHeaders() -> get('X-INVOICE-ID');

            if (!$invoiceID) {
                throw new UnauthorizedHttpException('No station ID provided');
            }

            $lines = Invoiceline::find()
                -> where(['invoice_id' => $invoiceID])
                -> with(['item', 'invoice'])
                -> asArray()
                -> all();

            return
                array_map(function ($line) {
                    $line['item'] = $line['item_id'];
                    $line['invoice'] = $line['invoice_id'];

                    unset($line['item_id'], $line['invoice_id']);
                    return $line;
                }, $lines);
        }

        public function actionCreate() {
            $request = \Yii::$app -> request -> post();
            $model = new Invoiceline();

            if ($model->load($request, '') && $model->save()) {
                return $model;
            }

            throw new BadRequestHttpException('Failed to create invoice line: ' . json_encode($model->errors));
        }
    }
?>