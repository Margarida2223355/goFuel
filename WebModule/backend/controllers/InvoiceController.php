<?php

namespace backend\controllers;

use common\models\Invoice;
use common\models\Station;
use common\models\StationUser;
use Mpdf\Mpdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
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
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['InvoiceIndexPermission'],
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'roles' => ['InvoiceViewPermission'],
                    ],
                    [
                        'actions' => ['finish'],
                        'allow' => true,
                        'roles' => ['InvoiceFinishPermission'],
                    ],
                    [
                        'actions' => ['print'],
                        'allow' => true,
                        'roles' => ['InvoicePrintPermission'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;
        $stationUser = StationUser::findOne(['user_id' => $currentUser->id]);
        $query = Invoice::find();

        if (Yii::$app->user->can('Admin')) {
            $query->orderBy(['state_id' => SORT_ASC])->all();
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
                    Yii::$app->session->set('alert', [
                        'type' => 'success',
                        'title' => 'Success!',
                        'message' => 'Invoice succefully verified.',
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                Yii::$app->session->set('alert', [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'The code displayed does not match the invoice verification code.',
                ]);
            }
        }
        $model->code = null;

        return $this->render('check', [
            'model' => $model,
        ]);
    }

    public function actionPrint($id)
    {
        $model = Invoice::findOne($id);
        if (!$model) {
            throw new \yii\web\NotFoundHttpException('Invoice não encontrada.');
        }

        $htmlContent = $this->renderPartial('print', ['model' => $model]);
        $mpdfConfig = [
            'tempDir' => Yii::getAlias('@runtime/mpdf'), // Define o diretório temporário para o mPDF
        ];

        $mpdf = new Mpdf($mpdfConfig);

        $mpdf->WriteHTML('<style>
            body { font-family: Arial, sans-serif; }
            h1 { text-align: center; }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
            th { background-color: #f4f4f4; }
        </style>');

        $mpdf->WriteHTML($mpdfConfig);

        $fileName = 'Invoice_' . $model->generateFinalCode() . '.pdf';
        return $mpdf->Output($fileName, \Mpdf\Output\Destination::INLINE);
    }

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
