<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\InvoiceLine;
use common\models\StationItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionAddtocart($id)
    {
        $quantity = Yii::$app->request->post('quantity', 1);
        $currentUser = Yii::$app->user->identity;
        if (!$currentUser) {
            throw new \yii\web\ForbiddenHttpException("User must be logged in to add items to the cart.");
        }

        $stationItem = StationItem::findOne($id);
        if (!$stationItem) {
            throw new \yii\web\NotFoundHttpException("The requested station item does not exist.");
        }

        $existInvoice = Invoice::findOne([
            'client_id' => $currentUser->id,
            'station_id' => $stationItem->station_id,
            'state_id' => 1
        ]);

        if ($existInvoice) {
            // Check if the invoice line already exists
            $existInvoiceLine = InvoiceLine::findOne([
                'invoice_id' => $existInvoice->id,
                'item_id' => $stationItem->item_id
            ]);

            if ($existInvoiceLine) {
                // Update existing invoice line
                $existInvoiceLine->qty += $quantity;
                $existInvoiceLine->total = $stationItem->price * $existInvoiceLine->qty;
                if (!$existInvoiceLine->update()) {
                    throw new \yii\web\ServerErrorHttpException("Failed to update the existing invoice line.");
                }
            } else {
                // Add new invoice line
                $invoiceLine = new InvoiceLine();
                $invoiceLine->item_id = $stationItem->item_id;
                $invoiceLine->qty = $quantity;
                $invoiceLine->invoice_id = $existInvoice->id;
                $invoiceLine->total = $stationItem->price * $quantity;
                if (!$invoiceLine->save()) {
                    throw new \yii\web\ServerErrorHttpException("Failed to save the new invoice line.");
                }
            }
            $existInvoice->updateTotal();
        } else {
            // Create new invoice if none exists
            $invoice = new Invoice();
            $invoice->client_id = $currentUser->id;
            $invoice->station_id = $stationItem->station_id;
            $invoice->invoice_date = date('Y-m-d H:i:s');
            $invoice->total = 0.0;
            $invoice->state_id = 1;

            if (!$invoice->save()) {
                throw new \yii\web\ServerErrorHttpException("Failed to create a new invoice.");
            }

            // Add a new invoice line
            $invoiceLine = new InvoiceLine();
            $invoiceLine->item_id = $stationItem->item_id;
            $invoiceLine->qty = $quantity;
            $invoiceLine->invoice_id = $invoice->id;
            $invoiceLine->total = $stationItem->price * $quantity;

            if (!$invoiceLine->save()) {
                throw new \yii\web\ServerErrorHttpException("Failed to save the invoice line for the new invoice.");
            }

            // Update the total for the new invoice
            $invoice->updateTotal();
        }

        return $this->redirect(['station/view', 'id' => $stationItem->station_id]);
    }

    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->where(['client_id' => $currentUser->id]),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexCart()
    {
        $currentUser = Yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => Invoice::find()->where(['client_id' => $currentUser->id, 'state_id' => 1]),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index-cart', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPay($id)
    {
        $invoice = $this->findModel($id);
        $invoice->state_id = 2;
        $invoice->code = $this->generateRandomCode();
        $invoice->save();

        return $this->redirect('index-cart');
    }

    private function generateRandomCode()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; // Letras maiúsculas e dígitos
        $randomCode = '';

        for ($i = 0; $i < 6; $i++) {
            $index = rand(0, strlen($characters) - 1); // Gera um índice aleatório
            $randomCode .= $characters[$index];
        }
        return $randomCode;
    }

    public function actionCancel($id)
    {
        $invoice = $this->findModel($id);
        $invoice->state_id = 3;

        return $this->redirect('index');
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {

        $model = new Invoice();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
