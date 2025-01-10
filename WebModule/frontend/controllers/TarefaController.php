<?php

namespace frontend\controllers;

use common\models\Tarefa;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TarefaController implements the CRUD actions for Tarefa model.
 */
class TarefaController extends Controller
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
        $currentUser = Yii::$app->user->identity;
        $dataProvider = new ActiveDataProvider([
            'query' => Tarefa::find()->where(['user_id' => $currentUser->id, 'is_done' => 0]),
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

    public function actionDone($id)
    {
        $model = $this->findModel($id);

        $model->is_done = 1;

        if ($model->save()) {
            return $this->redirect('index');
        }
    }

    protected function findModel($id)
    {
        if (($model = Tarefa::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
