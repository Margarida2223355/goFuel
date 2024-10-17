<?php

namespace backend\controllers;

use common\models\Item;
use common\models\Station;
use common\models\StationItem;
use common\models\StationUser;
use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StationController implements the CRUD actions for Station model.
 */
class StationController extends Controller
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

    /**
     * Lists all Station models.
     *
     * @return string
     */
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
        } elseif (isset($roles['Manager'])) {
            $query->where(['manager_id' => $currentUser->id]);
        } else {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
        $station = Station::findOne($id); // Busca a estação pelo ID

        if (!$station) {
            throw new \yii\web\NotFoundHttpException('A estação não foi encontrada.');
        }

        return $this->render('view', [
            'station' => $station, // Passa o modelo da estação para a view
        ]);
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
                Yii::$app->session->setFlash('success', 'Item added successfully with price.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to add item.');
            }
        }

        return $this->redirect(['station/view', 'id' => $stationId]);
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Associa a estação ao manager
            $managerId = Yii::$app->request->post('Station')['manager_id'];
            if ($managerId) {
                $stationUser = new StationUser();
                $stationUser->user_id = $managerId;
                $stationUser->station_id = $model->id;
                $stationUser->save();
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'managersList' => $managersList,
        ]);
    }



    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $managers = UserInfo::find()
            ->where(['role' => 'Manager'])
            ->all();

        $managersList = \yii\helpers\ArrayHelper::map($managers, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'managersList' => $managersList,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Station::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
