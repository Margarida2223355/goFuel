<?php

namespace backend\controllers;

use backend\models\ItemStationForm;
use common\models\Item;
use common\models\ItemStock;
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

        if ($isAdmin) {
            // Se sim, busca os items
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => Item::find(),
            ]);

            return $this->render('admin-index', [
                'dataProvider' => $dataProvider,
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

        // Verifica se o usuário selecionou uma estação via POST ou GET
        $stationId = Yii::$app->request->post('stationId') ?? Yii::$app->request->get('stationId');

        // Se o usuário tem estações associadas mas não escolheu uma, seleciona a primeira estação associada
        if (!$stationId && !empty($stations)) {
            $stationId = $stations[0]->id;
        }

        // Caso exista um stationId válido, busca os itens da estação
        if ($stationId) {
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => StationItem::find()->where(['station_id' => $stationId])->with('item'),
            ]);
        } else {
            // Se não há uma estação válida, retorna um array vazio
            $dataProvider = new \yii\data\ArrayDataProvider([
                'allModels' => [],
            ]);
        }

        return $this->render('index', [
            'model' => $model,
            'stations' => $stations,
            'stationId' => $stationId,
            'dataProvider' => $dataProvider,
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
        /*if (!Yii::$app->user->can('createItem')) {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }

        $model = new Item();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);*/

        $model = new Item();

        $subcategories = Subcategory::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'subcategories' => $subcategories,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $subcategories = Subcategory::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'subcategories' => $subcategories,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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

            if ($model->validate()) {
                $stationItem = new StationItem();
                $stationItem->station_id = $stationId;
                $stationItem->item_id = $model->item_id;
                $stationItem->price = $model->price;

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

    public function actionUpdateAssociation($id)
    {
        $stationItem = StationItem::findOne($id);

        if (!$stationItem) {
            throw new NotFoundHttpException('A associação não foi encontrada.');
        }

        if ($stationItem->load(Yii::$app->request->post()) && $stationItem->save()) {
            Yii::$app->session->setFlash('success', 'Preço atualizado com sucesso.');
            return $this->redirect(['index', 'stationId' => $stationItem->station_id]);
        }

        return $this->render('update-association', [
            'model' => $stationItem,
        ]);
    }

    public function actionRestock($id)
    {
        // Encontra o item baseado no ID
        $item = Item::findOne($id);
        if (!$item) {
            throw new NotFoundHttpException('Item not found.');
        }

        // Encontra o stock do item para a estação atual
        $stationId = Yii::$app->user->identity->station_id; // Pega a estação do usuário logado (In Charge)
        $itemStock = ItemStock::findOne(['item_id' => $id, 'station_id' => $stationId]);

        if ($itemStock) {
            // Incrementa o estoque de acordo com a quantidade de restock definida no item
            $itemStock->stock += $item->restock_qty;
            if ($itemStock->save()) {
                Yii::$app->session->setFlash('success', 'Item restocked successfully.');
            } else {
                Yii::$app->session->setFlash('error', 'Failed to restock item.');
            }
        } else {
            // Se não existir um registro de stock, cria um novo
            $itemStock = new ItemStock();
            $itemStock->item_id = $id;
            $itemStock->station_id = $stationId;
            $itemStock->stock = $item->restock_qty; // Inicia o estoque com a quantidade de restock

            if ($itemStock->save()) {
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
