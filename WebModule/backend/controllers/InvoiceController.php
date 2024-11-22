<?php

namespace backend\controllers;

use common\models\Invoice;
use common\models\Station;
use common\models\StationUser;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'view', 'finish'],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'find-model'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['finish'],
                        'allow' => true,
                        'roles' => ['manager', 'Incharges', 'Employee'],
                    ],
                    [
                        'actions' => ['finish'],
                        'allow' => false,
                        'roles' => ['Admin'],
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
        $currentUser = Yii::$app->user->identity;
        $stationUser = StationUser::findOne(['user_id' => $currentUser->id]);
        $query = Invoice::find();

        if (Yii::$app->user->can('Admin')) {
            $query->all();
        } elseif (Yii::$app->user->can('Manager')) {
            $stations = Station::find()->where(['manager_id' => $currentUser->id])->all();

            if (!empty($stations)) {
                $stationIds = array_column($stations, 'id');
                $query->where(['station_id' => $stationIds])->orderBy(['state_id' => SORT_DESC]);
            } else {
                $query->where(['id' => 0]);
            }
        } elseif (Yii::$app->user->can('Incharge') || Yii::$app->user->can('Employee')) {
            if ($stationUser) {
                $query->where(['state_id' => 2, 'station_id' => $stationUser->station_id]);
            } else {
                $query->where(['id' => 0]);
            }
        } else {
            $query->where(['id' => 0]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'state_id' => SORT_DESC,
                ]
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionFinish($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {

            if ($model->code === $model->getOldAttribute('code')) {
                $model->state_id = 4;

                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Fatura finalizada com sucesso.');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Código incorreto. Por favor, tente novamente.');
            }
        }
        $model->code = null;

        return $this->render('check', [
            'model' => $model,
        ]);
    }

    /*public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }*/

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $model->state_id = 3;

        if ($model->save) {
            return $this->redirect(['index']);
        }

        //SetErrorFlash
    }

    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
