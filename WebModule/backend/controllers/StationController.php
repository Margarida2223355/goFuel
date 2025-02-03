<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use common\models\Item;
use common\models\Pump;
use common\models\Station;
use common\models\StationItem;
use common\models\StationUser;
use common\models\User;
use common\models\UserInfo;
use hail812\adminlte\widgets\Alert;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class StationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['StationIndexPermission'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['StationViewPermission'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['StationCreatePermission'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['StationUpdatePermission'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['StationDeletePermission'],
                    ],
                ],
            ],
        ];
    }

    public function actionView($id)
    {

        $station = $this->findModel($id);
        $model = new ItemStationForm();

        if ($id) {
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => StationItem::find()->where(['station_id' => $id])->with('item'),
            ]);
        } else {
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);
        }

        return $this->render('view', [
            'station' => $station,
            'model' => $model,
            'id' => $id,
            'dataProvider' => $dataProvider
        ]);
    }

    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser) {
            throw new \yii\web\ForbiddenHttpException('O usuário logado não possui permissão para visualizar esta página.');
        }

        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($currentUser->id);

        $query = Station::find();

        if (isset($roles['Admin'])) {
            $query->orderBy(['is_deleted' => SORT_ASC]);
        } elseif (isset($roles['Manager'])) {
            $query->where(['manager_id' => $currentUser->id]);
        } else {
            return $this->redirect(['view', 'id' => $currentUser->stationUsers->station_id]);
        }

        $model = new Station();

        $managers = User::find()
            ->joinWith('authAssignments')
            ->where(['auth_assignment.item_name' => 'Manager'])
            ->all();

        $managersList = \yii\helpers\ArrayHelper::map($managers, 'id', function ($model) {
            return $model->userInfo ? $model->userInfo->name : 'N/A';
        });

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $isUpdate = false;

        return $this->render('index', [
            'model' => $model,
            'managersList' => $managersList,
            'dataProvider' => $dataProvider,
            'isUpdate' => $isUpdate,
            'currentPumpsCount' => 0,
        ]);
    }

    public function actionCreate()
    {
        $model = new Station();

        $managers = User::find()
            ->joinWith('authAssignments')
            ->where(['auth_assignment.item_name' => 'Manager'])
            ->all();

        $managersList = \yii\helpers\ArrayHelper::map($managers, 'id', function ($model) {
            return $model->userInfo ? $model->userInfo->name : 'N/A';
        });

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            /*$managerId = Yii::$app->request->post('Station')['manager_id'];
            if ($managerId) {
                $stationUser = new StationUser();
                $stationUser->user_id = $managerId;
                $stationUser->station_id = $model->id;
                $stationUser->save();
            }*/

            if ($model->save() && $model->upload()) {
                return $this->redirect(['index']);
            }

            $pumpsCount = Yii::$app->request->post('Station')['pumps_count'] ?? 0;

            for ($i = 0; $i < $pumpsCount; $i++) {
                $pump = new Pump();
                $pump->station_id = $model->id;
                $pump->save();
            }

            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'managersList' => $managersList,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $managers = User::find()
            ->joinWith('authAssignments')
            ->where(['auth_assignment.item_name' => 'Manager'])
            ->all();

        $managersList = \yii\helpers\ArrayHelper::map($managers, 'id', function ($model) {
            return $model->userInfo ? $model->userInfo->name : 'N/A';
        });

        $isUpdate = true;
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Station::find()->orderBy(['is_deleted' => SORT_ASC]),
        ]);

        $currentPumpsCount = Pump::find()->where(['station_id' => $id])->count();

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

            $pumpsCount = Yii::$app->request->post('Station')['pumps_count'] ?? 0;

            Pump::deleteAll(['station_id' => $model->id]);

            for ($i = 0; $i < $pumpsCount; $i++) {
                $pump = new Pump();
                $pump->station_id = $model->id;
                $pump->save();
            }

            return $this->redirect(['index']);
        }

        return $this->render('index', [
            'model' => $model,
            'managersList' => $managersList,
            'dataProvider' => $dataProvider,
            'isUpdate' => $isUpdate,
            'currentPumpsCount' => $currentPumpsCount,
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
                    'message' => 'Item successfully deleted.',
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

    public function actionAddItem()
    {
        $stationId = Yii::$app->request->post('station_id');
        $itemId = Yii::$app->request->post('item_id');
        $price = Yii::$app->request->post('price');

        if ($stationId && $itemId && $price) {
            $stationItem = new StationItem();
            $stationItem->station_id = $stationId;
            $stationItem->item_id = $itemId;
            $stationItem->price = $price;

            if ($stationItem->save()) {
                Yii::$app->session->set('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Item added successfully with price.',
                ]);
            } else {
                Yii::$app->session->set('alert', [
                    'type' => 'error',
                    'title' => 'Error!',
                    'message' => 'Failed to add item.',
                ]);
            }
        }

        return $this->redirect(['station/view', 'id' => $stationId]);
    }

    protected function findModel($id)
    {
        if (($model = Station::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
