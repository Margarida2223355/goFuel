<?php

namespace backend\controllers;

use Yii;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StationItemController extends Controller
{

    public function actionAddItemToStation($station_id, $item_id)
    {
        $station = Station::findOne($station_id);
        $item = Item::findOne($item_id);

        if (!$station || !$item) {
            throw new NotFoundHttpException('Estação ou Item não encontrado.');
        }

        $station->link('items', $item);

        return $this->redirect(['station/view', 'id' => $station_id]);
    }

    public function actionRemoveItemFromStation($station_id, $item_id)
    {
        $station = Station::findOne($station_id);
        $item = Item::findOne($item_id);

        if (!$station || !$item) {
            throw new NotFoundHttpException('Estação ou Item não encontrado.');
        }

        $station->unlink('items', $item, true);

        return $this->redirect(['station/view', 'id' => $station_id]);
    }

    public function actionDelete($id)
    {
        $model = StationItem::findOne($id);

        if ($model !== null) {
            $model->delete();

            Yii::$app->session->setFlash('success', 'Item removed successfully.');
        } else {
            Yii::$app->session->setFlash('error', 'Item not found.');
        }

        return $this->redirect(['station/view', 'id' => $model->station_id]);
    }
}
