<?php

namespace backend\controllers;

use common\models\Category;
use Yii;
use common\models\Subcategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SubcategoryController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['Admin'],
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => false,
                        'roles' => ['Manager', 'Incharge', 'Employee'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) {
                    \Yii::$app->session->setFlash('error', 'Você não tem permissão para acessar esta página.');
                    return \Yii::$app->getResponse()->redirect(\Yii::$app->request->referrer ?: \Yii::$app->homeUrl);
                },
            ],
        ];
    }

    public function actionCreate()
    {
        $model = new Subcategory();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            if (isset($data['Subcategory']['id']) && !empty($data['Subcategory']['id'])) {
                $model = Subcategory::findOne($data['Subcategory']['id']);
            }

            if ($model->load($data)) {
                if ($model->save()) {
                    return $this->redirect(['category/view', 'id' => $model->category_id]);
                }
            }
        }

        return $this->redirect(['category/view', 'id' => $model->category_id]);
    }


    public function actionUpdate($id)
    {
        $model = Subcategory::findOne($id);
        if ($model === null) {
            throw new NotFoundHttpException('The requested subcategory does not exist.');
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['category/update', 'id' => $model->category_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $categoryId = $model->category_id;

        if ($model->delete()) {
            return $this->redirect(['category/view', 'id' => $categoryId]);
        }

        throw new NotFoundHttpException('The requested subcategory does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = Subcategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
