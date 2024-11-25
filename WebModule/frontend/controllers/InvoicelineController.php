<?php

namespace frontend\controllers;

use common\models\Invoice;
use common\models\Invoiceline;
use common\models\StationItem;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoicelineController implements the CRUD actions for Invoiceline model.
 */
class InvoicelineController extends Controller
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

    public function actionUpdateQuantity($id)
    {
        $line = InvoiceLine::findOne($id);
        $quantity = Yii::$app->request->post('quantity', 1);
        $action = Yii::$app->request->post('action');
        $invoice = Invoice::findOne($line->invoice_id);

        $item = StationItem::findOne(['item_id' => $line->item_id, 'station_id' => $line->invoice->station_id]);


        if ($line && $quantity > 0) {
            if ($action === 'minus') {
                if ($line->item->subcategory->category->id == 1) {
                    $litersToRemove = $quantity / $item->price;
                    $line->qty = max(0, $line->qty - $litersToRemove);
                } else {
                    $line->qty = max(0, $line->qty - $quantity);
                }
            } elseif ($action === 'plus') {
                if ($line->item->subcategory->category->id == 1) {
                    $litersToAdd = $quantity / $item->price;
                    $line->qty += $litersToAdd;
                } else {
                    $line->qty += $quantity;
                }
            }
            $line->total = $line->qty * $item->price;
            $line->save();
            $invoice->updateTotal();
        }

        return $this->redirect(['invoice/view', 'id' => $line->invoice_id]);
    }


    public function actionMinus($id)
    {
        $line = $this->findModel($id);
        $stationItem = StationItem::findOne(['station_id' => $line->invoice->station_id, 'item_id' => $line->item_id]);

        if ($line->qty == 1) {
            return $this->delete($id);
        } else {
            $line->qty--;
            $line->total = $stationItem->price * $line->qty;
            $line->update();
        }

        $invoice = Invoice::findOne($line->invoice_id);
        $invoice->updateTotal();

        return $this->redirect(['/invoice/view', 'id' => $line->invoice_id]);
    }

    public function actionPlus($id)
    {
        $line = $this->findModel($id);
        $stationItem = StationItem::findOne(['station_id' => $line->invoice->station_id, 'item_id' => $line->item_id]);

        if ($stationItem->stock < ($line->qty + 1)) {
            Yii::$app->session->setFlash('error', 'Not enough stock for the desired quantity.');
            return $this->redirect(['/invoice/view', 'id' => $line->invoice_id]);
        }

        $line->qty++;
        $line->total = $stationItem->price * $line->qty;
        $line->update();

        $invoice = Invoice::findOne($line->invoice_id);
        $invoice->updateTotal();

        return $this->redirect(['/invoice/view', 'id' => $line->invoice_id]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $invoice_id = $model->invoice_id;
        $model->delete();

        $invoice = Invoice::findOne($invoice_id);
        $invoice->updateTotal();

        return $this->redirect(['/invoice/view', 'id' => $invoice_id]);
    }

    protected function findModel($id)
    {
        if (($model = Invoiceline::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
