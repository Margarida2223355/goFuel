<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\ClientStation;
use common\models\Item;
use common\models\Station;
use common\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
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

    public function actionStarred($station_id)
    {
        $currentUser = Yii::$app->user->identity;
        $starredStation = ClientStation::findOne(['client_id' => $currentUser->id]);

        if ($starredStation) {
            if ((int)$starredStation->station_id != $station_id) {
                $starredStation->client_id = $currentUser->id;
                $starredStation->station_id = $station_id;
                $starredStation->update();
            } else {
                $starredStation->delete();
            }
        } else {
            $starredStation = new ClientStation();
            $starredStation->client_id = $currentUser->id;
            $starredStation->station_id = $station_id;
            $starredStation->save();
        }

        return $this->redirect(['index']);
    }

    /**
     * Displays a single Station model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $categories = Category::find()->all();
        $subcategories = Subcategory::find()->all();

        $filterCategory = Yii::$app->request->get('filterCategory');
        $filterSubcategory = Yii::$app->request->get('filterSubcategory');

        $dataProvider = new ArrayDataProvider([
            'allModels' => array_filter($model->stationItems, function ($stationItem) use ($filterCategory, $filterSubcategory) {
                if ($stationItem->is_deleted != 0) {
                    return false;
                }
                if (!empty($filterCategory) && $stationItem->item->subcategory->category_id != $filterCategory) {
                    return false;
                }
                if (!empty($filterSubcategory) && $stationItem->item->subcategory_id != $filterSubcategory) {
                    return false;
                }
                return true;
            }),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('view', [
            'model' => $model,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'dataProvider' => $dataProvider,
        ]);
    }


    protected function findModel($id)
    {
        if (($model = Station::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
