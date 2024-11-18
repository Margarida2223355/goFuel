<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use Yii;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StationItemController extends Controller
{

    public function actionAssociate()
    {
        $model = new ItemStationForm();

        if (Yii::$app->request->isPost) {
            $stationId = Yii::$app->request->post('station_id');
            $model->station_id = $stationId;
            $model->item_id = Yii::$app->request->post('ItemStationForm')['item_id'];
            $model->price = Yii::$app->request->post('ItemStationForm')['price'];

            $item = Item::findOne(Yii::$app->request->post('ItemStationForm')['item_id']);

            if ($model->validate()) {
                $stationItem = new StationItem();
                $stationItem->station_id = $stationId;
                $stationItem->item_id = $model->item_id;
                $stationItem->price = $model->price;
                $stationItem->stock = $item->restock_qty;

                if ($stationItem->save()) {
                    Yii::$app->session->setFlash('success', 'Item associated successfully.');
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to associate item: ' . json_encode($stationItem->getErrors()));
                }
            } else {
                Yii::$app->session->setFlash('error', 'Validation failed: ' . json_encode($model->getErrors()));
            }

            return $this->redirect(['item/index', 'stationId' => $stationId]);
        }

        return $this->redirect(['item/index']);
    }


    public function actionDeleteAssociation($id)
    {
        $model = StationItem::findOne($id);

        $stationId = $model->station_id;

        if ($model !== null) {
            $model->delete();
            Yii::$app->session->setFlash('success', 'A associação foi deletada com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'A associação não foi encontrada.');
        }

        return $this->redirect(['item/index', 'stationId' => $stationId]);
    }

    public function actionUpdateAssociation($id)
    {
        $stationItem = StationItem::findOne($id);

        if (!$stationItem) {
            throw new NotFoundHttpException('A associação não foi encontrada.');
        }
        if ($stationItem->load(Yii::$app->request->post()) && $stationItem->save()) {
            Yii::$app->session->setFlash('success', 'Associação atualizada com sucesso.');
            return $this->redirect(['item/index', 'stationId' => $stationItem->station_id]);
        }

        $stations = Station::find()->all();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => StationItem::find()->where(['station_id' => $stationItem->station_id])->with('item'),
        ]);

        return $this->redirect([
            'item/index',
            'stationId' => $stationItem->station_id,
            'isUpdate' => true,
        ]);
    }
}
