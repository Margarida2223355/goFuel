<?php

namespace backend\controllers;

use common\models\Category;
use Yii;
use common\models\Subcategory;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SubcategoryController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['SubcategoryCreatePermission'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['SubcategoryUpdatePermission'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['SubcategoryDeletePermission'],
                    ],
                ],
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

    public function actionUpdate($id, $subcategory_id = null)
    {
        $model = Category::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Category not found.');
        }

        // Instanciar uma nova subcategoria por padrão
        $newSubcategory = new Subcategory();

        // Se o parâmetro `subcategory_id` foi passado, carregue os dados da subcategoria existente
        if ($subcategory_id) {
            $newSubcategory = Subcategory::findOne($subcategory_id);
            if (!$newSubcategory) {
                throw new NotFoundHttpException('Subcategory not found.');
            }
        }

        return $this->render('update', [
            'model' => $model,
            'newSubcategory' => $newSubcategory,
            'subcategoriesDataProvider' => new ActiveDataProvider([
                'query' => Subcategory::find()->where(['category_id' => $id, 'is_deleted' => false]),
            ]),
        ]);
    }

    public function actionDelete($id)
    {
        if ($id) {
            $model = $this->findModel($id);
            if ($model->is_deleted == true) {
                $model->is_deleted = 0;
                Yii::$app->session->set('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Subcategory successfully desabled.',
                ]);
            } else {
                $model->is_deleted = 1;
                $cat = $model->category;
                if ($cat->is_deleted == 1) {
                    $cat->is_deleted = 0;
                    $cat->save();
                }
                Yii::$app->session->set('alert', [
                    'type' => 'success',
                    'title' => 'Success!',
                    'message' => 'Subcategory successfully enabled.',
                ]);
            }
            $model->save();
        } else {
            Yii::$app->session->set('alert', [
                'type' => 'error',
                'title' => 'Error!',
                'message' => 'An error occurred.',
            ]);
        }
        return $this->redirect(['category/view', 'id' => $model->category_id]);


        // throw new NotFoundHttpException('The requested subcategory does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = Subcategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
