<?php

namespace backend\controllers;

use common\models\Category;
use common\models\Subcategory;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => \yii\filters\AccessControl::class,
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create', 'update', 'delete'],
                        'allow' => true,
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
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find(),
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
        $model = new Category();

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        $newSubcategory = new Subcategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Category updated successfully!');
            return $this->refresh();
        }

        $subcategoriesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id]),
        ]);
        $isUpdate = false;

        return $this->render('view', [
            'model' => $model,
            'newSubcategory' => $newSubcategory,
            'subcategoriesDataProvider' => $subcategoriesDataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect('index');
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $newSubcategory = new Subcategory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Category updated successfully!');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $subcategoriesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id]),
        ]);

        return $this->render('view', [
            'model' => $model,
            'newSubcategory' => $newSubcategory,
            'subcategoriesDataProvider' => $subcategoriesDataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
