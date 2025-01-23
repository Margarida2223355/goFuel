<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use Yii;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use common\models\User;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StationItemController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['associate'],
                        'allow' => true,
                        'roles' => ['StationItemAssociatePermission'],
                    ],
                    [
                        'actions' => ['delete-association'],
                        'allow' => true,
                        'roles' => ['StationItemDeleteAssociationPermission'],
                    ],
                    [
                        'actions' => ['update-association'],
                        'allow' => true,
                        'roles' => ['StationItemUpdateAssociationPermission'],
                    ],
                    [
                        'actions' => ['restock'],
                        'allow' => true,
                        'roles' => ['ItemRestockPermission'],
                    ],
                ],
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
                    Yii::$app->session->set('alert', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Item associated successfully.',
                    ]);
                } else {
                    Yii::$app->session->set('alert', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Failed to associate item: ' . json_encode($stationItem->getErrors()),
                    ]);
                }
            } else {
                Yii::$app->session->set('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Validation failed: ' . json_encode($model->getErrors()),
                ]);
            }

            return $this->redirect(['item/index', 'stationId' => $stationId]);
        }

        return $this->redirect(['item/index']);
    }

    public function actionDeleteAssociation($item_id, $station_id)
    {

        if ($station_id || $item_id) {
            $model = $this->findModel($station_id, $item_id);
            $stationId = $model->station_id;
            if ($model) {
                if ($model->is_deleted == true) {
                    $model->is_deleted = 0;
                    if ($model->save()) {
                        Yii::$app->session->set('alert', [
                            'type' => 'success',
                            'title' => 'Success!',
                            'message' => 'Category successfully enabled.',
                        ]);
                    }
                } else {
                    $model->is_deleted = 1;
                    if ($model->save()) {
                        Yii::$app->session->set('alert', [
                            'type' => 'success',
                            'title' => 'Success!',
                            'message' => 'Category successfully desabled.',
                        ]);
                    }
                }
            }
        } else {
            Yii::$app->session->set('alert', [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'An error occurred.',
            ]);
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
            Yii::$app->session->set('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Association successfully updated.',
            ]);
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

    public function actionRestock($item_id, $station_id)
    {
        $item = Item::findOne($item_id);
        if (!$item) {
            throw new NotFoundHttpException('Item not found.');
        }

        $sitem = StationItem::findOne(['item_id' => $item_id, 'station_id' => $station_id]);

        if ($sitem) {
            $sitem->stock += $item->restock_qty;
            if ($sitem->save()) {
                Yii::$app->session->set('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Item restocked successfully.',
                ]);
            } else {
                Yii::$app->session->set('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Failed to restock item.',
                ]);
            }
        }

        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    protected function findModel($station_id, $item_id)
    {
        if (($model = StationItem::findOne(['station_id' => $station_id, 'item_id' => $item_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
