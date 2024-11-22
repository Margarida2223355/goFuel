<?php

namespace frontend\controllers;

use common\models\ClientStation;
use common\models\Item;
use common\models\Station;
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Station model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Station the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Station::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
