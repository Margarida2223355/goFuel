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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['add-item-to-station', 'update-association', 'delete'],
                'rules' => [
                    [
                        'actions' => ['add-item-to-station', 'update-association', 'delete'],
                        'allow' => true,
                        'roles' => ['Manager'],
                    ],
                    [
                        'actions' => ['add-item-to-station', 'update-association', 'delete'],
                        'allow' => false,
                        'roles' => ['Admin', 'Incharge', 'Employee'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    \Yii::$app->session->setFlash('error', 'Você não tem permissão para acessar esta página.');
                    return \Yii::$app->getResponse()->redirect(\Yii::$app->request->referrer ?: \Yii::$app->homeUrl);
                },
            ],
        ];
    }

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


    public function actionDeleteAssociation($station_id, $item_id)
    {

        if ($station_id || $item_id) {
            $model = $this->findModel($station_id, $item_id);
            $stationId = $model->station_id;
            if ($model) {
                $model->is_deleted = 0;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Item successfully deleted.');
                }
            }
        } else {
            Yii::$app->session->setFlash('error', 'An error occurred.');
        }

        return $this->redirect(['item/index', 'stationId' => $stationId]);
    }

    public function actionUpdateAssociation($station_id, $item_id)
    {
        $stationItem = $this->findModel($station_id, $item_id);

        if (!$stationItem) {
            throw new NotFoundHttpException('A associação não foi encontrada.');
        }
        if ($stationItem->load(Yii::$app->request->post()) && $stationItem->save()) {
            Yii::$app->session->setFlash('success', 'Associação atualizada com sucesso.');
            return $this->redirect(['item/index', 'stationId' => $stationItem->station_id]);
        }

        $stations = Station::find()->all();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => StationItem::find()->where(['station_id' => $station_id])->with('item'),
        ]);

        return $this->redirect([
            'item/index',
            'stationId' => $stationItem->station_id,
            'isUpdate' => true,
        ]);
    }

    protected function findModel($station_id, $item_id)
    {
        if (($model = StationItem::findOne(['station_id' => $station_id, 'item_id' => $item_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
