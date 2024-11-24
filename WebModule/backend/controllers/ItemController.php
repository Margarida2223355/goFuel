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
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'associate', 'delete-association', 'update-association', 'restock'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'find-model'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                    [
                        'actions' => ['create', 'update'],
                        'allow' => false,
                        'roles' => ['Manager', 'Incharge', 'Employee'],
                    ],
                    [
                        'actions' => [
                            'associate',
                            'delete-association',
                            'update-association',
                            'restock'
                        ],
                        'allow' => true,
                        'roles' => ['Manager', 'Incharge'],
                    ],
                    [
                        'actions' => [
                            'associate',
                            'delete-association',
                            'update-association',
                            'restock'
                        ],
                        'allow' => false,
                        'roles' => ['Admin', 'Employee'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    \Yii::$app->session->setFlash('error', 'Você não tem permissão para acessar esta página.');
                    return \Yii::$app->getResponse()->redirect(\Yii::$app->request->referrer ?: \Yii::$app->homeUrl);
                },
            ],
        ];
    }


    public function actionIndex()
    {
        $auth = Yii::$app->authManager;

        $isAdmin = $auth->checkAccess(Yii::$app->user->id, 'Admin');

        if ($isAdmin) {
            // Se sim, busca os items
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Item::find()->where(['is_deleted' => false]),
            ]);
            $model = new Item();
            $subcategories = Subcategory::find()->where(['is_deleted' => false])->all();

            return $this->render('admin-index', [
                'dataProvider' => $dataProvider,
                'model' => $model,
                'subcategories' => $subcategories,
                'isUpdate' => false,
            ]);
        }

        // Para "Manager", "In Charge" e "Employee"
        // Verifica se o usuário é Manager
        $isManager = $auth->checkAccess(Yii::$app->user->id, 'Manager');
        $isInCharge = $auth->checkAccess(Yii::$app->user->id, 'In Charge');
        $isEmployee = $auth->checkAccess(Yii::$app->user->id, 'Employee');

        // Se for "Manager", recupera as estações gerenciadas por esse usuário
        if ($isManager) {
            $stations = Station::find()->where(['manager_id' => Yii::$app->user->id])->all();
        } else {
            // Para "In Charge" ou "Employee", pode usar a tabela intermediária que associa usuários à estação
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
                'query' => StationItem::find()->where(['station_id' => $stationId, 'is_deleted' => false])->with('item'),
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
            'query' => Item::find(),
        ]);
        $stationId = Yii::$app->request->post('stationId') ?? Yii::$app->request->get('stationId');

        $subcategories = Subcategory::find()->where(['is_deleted' => false])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        }

        return $this->render('admin-index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
            'subcategories' => $subcategories,
            'isUpdate' => true,
        ]);
    }

    public function actionDelete($id)
    {
        if ($id) {
            $model = $this->findModel($id);
            if ($model) {
                $model->is_deleted = 0;
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Item successfully deleted.');
                }
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
        $item = StationItem::findOne(['item_id' => $id, 'station_id' => $stationId]);

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
