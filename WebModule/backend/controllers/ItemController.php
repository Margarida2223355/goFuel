<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use common\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class ItemController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['ItemIndexPermission'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['ItemViewPermission'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['ItemCreatePermission'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ItemUpdatePermission'],
                    ],
                    [
                        'actions' => ['associate'],
                        'allow' => true,
                        'roles' => ['ItemAssociatePermission'],
                    ],
                    [
                        'actions' => ['update-association'],
                        'allow' => true,
                        'roles' => ['StationItemUpdateAssociationPermission'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($stationId = null)
    {
        $auth = Yii::$app->authManager;

        $isAdmin = $auth->checkAccess(Yii::$app->user->id, 'Admin');
        $isManager = $auth->checkAccess(Yii::$app->user->id, 'Manager');
        $stations = [];

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
            $station = Station::findOne(['manager_id' => Yii::$app->user->id]);

            $stations = Station::find()->where(['manager_id' => Yii::$app->user->id])->all();
        } else {
            $station = Station::find()
                ->joinWith('stationUsers')
                ->where(['station_users.user_id' => Yii::$app->user->id])
                ->one();
        }

        $model = new ItemStationForm();
        if ($stationId == null) {
            $stationId = Yii::$app->request->post('stationId') ?? $station->id;
        }

        if (!$stationId && !empty($stations)) {
            $stationId = $stations[0]->id;
        }

        if ($stationId) {
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => StationItem::find()->where(['station_id' => $stationId])->with('item')->orderBy(['is_deleted' => SORT_ASC]),
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

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile'); // Captura a imagem

            //dd($model->imageFile);

            if ($model->save() && $model->upload()) {
                return $this->redirect(['index']);
            }
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

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile) {
                $model->upload();
            } else {
                $model->image = $model->getOldAttribute('image');
            }

            if ($model->save()) {
                return $this->redirect(['index']);
            }
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
                Yii::$app->session->set('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Item successfully desabled.',
                ]);
            }
        } else {
            Yii::$app->session->set('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'An error occurred.',
            ]);
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
                    Yii::$app->session->set('alert', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Item successfully associated.',
                    ]);
                } else {
                    Yii::$app->session->set('alert', [
                        'type' => 'error',
                        'title' => 'Error!',
                        'message' => 'Failed to associate item.',
                    ]);
                }
            } else {
                Yii::$app->session->set('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Validation failed: ' . json_encode($model->getErrors()),
                ]);
            }

            return $this->redirect(['index', 'stationId' => $stationId]);
        }

        return $this->redirect(['index']);
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

    protected function findModel($id)
    {
        if (($model = Item::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
