<?php

namespace backend\controllers;

use common\models\Item;
use common\models\Station;
use common\models\StationItem;
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
        $dataProvider = new ActiveDataProvider([
            'query' => Station::find(),
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $currentUser = Yii::$app->user->identity;

        // Verifica se o usuário logado é um Manager e tem permissão para acessar esta estação
        if ($currentUser && $currentUser->userInfo->role === 'Manager') {
            $station = Station::findOne(['id' => $id, 'manager_id' => $currentUser->userInfo->id]);

            if (!$station) {
                throw new NotFoundHttpException('Você não tem permissão para acessar essa estação.');
            }
        } else {
            throw new \yii\web\ForbiddenHttpException('Você não tem permissão para acessar esta página.');
        }

        // DataProvider para os itens associados a esta estação
        $itemsDataProvider = new \yii\data\ActiveDataProvider([
            'query' => StationItem::find()->where(['station_id' => $station->id])->with('item'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Itens disponíveis que ainda não estão associados a esta estação
        $availableItems = Item::find()
            ->where(['NOT IN', 'id', StationItem::find()->select('item_id')->where(['station_id' => $station->id])])
            ->all();

        return $this->render('view', [
            'station' => $station,
            'itemsDataProvider' => $itemsDataProvider,
            'availableItems' => $availableItems,
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

        $managers = UserInfo::find()
            ->where(['role' => 'Manager'])
            ->all();

        $managersList = \yii\helpers\ArrayHelper::map($managers, 'id', 'name');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
