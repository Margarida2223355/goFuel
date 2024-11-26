<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use common\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;

class ItemController extends Controller
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


    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $isAdmin = $auth->checkAccess(Yii::$app->user->id, 'Admin');
        $isManager = $auth->checkAccess(Yii::$app->user->id, 'Manager');

        if ($isAdmin) {
            // Se sim, busca os items
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Item::find()->orderBy(['is_deleted' => SORT_ASC])
            ]);
            $model = new Item();
            $subcategories = Subcategory::find()->where(['is_deleted' => false])->all();

            $subcategoriesList =  \yii\helpers\ArrayHelper::map($subcategories, 'id', 'description');

            return $this->render('admin-index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'subcategories' => $subcategoriesList,
                'isUpdate' => false,
            ]);
        } elseif ($isManager) {
            $stations = Station::find()->where(['manager_id' => Yii::$app->user->id])->all();
        } else {
            $stations = Station::find()
                ->joinWith('stationUsers')
                ->where(['station_users.user_id' => Yii::$app->user->id])
                ->all();
        }

        $model = new ItemStationForm();

        $stationId = Yii::$app->request->post('stationId') ?? Yii::$app->request->get('stationId');

        if (!$stationId && !empty($stations)) {
            $stationId = $stations[0]->id;
        }

        if ($stationId) {
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => StationItem::find()->where(['station_id' => $stationId])->with('item')->orderBy(['is_deleted' => SORT_DESC]),
            ]);
        } else {
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'stations' => $stations,
            'stationId' => $stationId,
            'dataProvider' => $dataProvider,
            'isUpdate' => false,
        ]);
    }



    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Item::find()->orderBy(['is_deleted' => SORT_ASC]),
        ]);
        $stationId = Yii::$app->request->post('stationId') ?? Yii::$app->request->get('stationId');

        $subcategories = Subcategory::find()->where(['is_deleted' => false])->all();

        $subcategoriesList =  \yii\helpers\ArrayHelper::map($subcategories, 'id', 'description');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('admin-index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'subcategories' => $subcategoriesList,
            'isUpdate' => true,
        ]);
    }

    public function actionDelete($id)
    {
        if ($id) {
            $model = $this->findModel($id);
            if ($model->is_deleted == true) {
                $model->is_deleted = 0;
            } else {
                $model->is_deleted = 1;
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Item successfully deleted.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'An error occurred.');
        }
        return $this->redirect(['index']);
    }

    public function actionAssociate()
    {
        $model = new ItemStationForm();

        if (Yii::$app->request->isPost) {
            $stationId = Yii::$app->request->post('station_id');
            $model->station_id = Yii::$app->request->post('station_id');
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

            return $this->redirect(['index', 'stationId' => $stationId]);
        }

        return $this->redirect(['index']);
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

        return $this->redirect(['index', 'stationId' => $stationId]);
    }

    public function actionUpdateAssociation($station_id, $item_id)
    {
        $stationItem = StationItem::findOne(['station_id' => $station_id, 'item_id' => $item_id]);

        if (!$stationItem) {
            throw new NotFoundHttpException('A associação não foi encontrada.');
        }

        $stations = Station::find()->where(['manager_id' => Yii::$app->user->id])->all();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => StationItem::find()->where(['station_id' => $stationItem->station_id, 'is_deleted' => false])->with('item'),
        ]);

        return $this->render('index', [
            'model' => $stationItem,
            'stations' => $stations,
            'stationId' => $stationItem->station_id,
            'dataProvider' => $dataProvider,
            'isUpdate' => true,
        ]);
    }

    public function actionRestock($id)
    {
        $item = Item::findOne($id);
        if (!$item) {
            throw new NotFoundHttpException('Item not found.');
        }

        $stationId = Yii::$app->user->identity->stationUsers->station_id;
        $item = StationItem::findOne(['item_id' => $id, 'station_id' => $stationId])->orderBy(['is_deleted' => SORT_DESC]);

        if ($item) {
            $item->stock += $item->restock_qty;
            if ($item->save()) {
                Yii::$app->session->setFlash('success', 'Item restocked successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to restock item.');
            }
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
