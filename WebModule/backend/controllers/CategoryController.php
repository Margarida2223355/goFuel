<?php

namespace backend\controllers;

use common\models\Category;
use common\models\Subcategory;
use Yii;
use yii\base\Model;
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
        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->orderBy(['is_deleted' => SORT_ASC]),
        ]);
        $model = new Category();
        $view = false;

        return $this->render('index', [
            'model' => $model,
            'view' => $view,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id, $subcategory_id = null)
    {
        $model = $this->findModel($id);

        $subcategory = new Subcategory();
        $view = true;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->set('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Category successfully updated!.',
            ]);
            return $this->refresh();
        }

        $subcategoriesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id])->orderBy(['is_deleted' => SORT_ASC]),
        ]);
        $isUpdate = false;

        if ($subcategory_id) {
            $subcategory = Subcategory::findOne($subcategory_id);
            $isUpdate = true;
            if (!$subcategory) {
                throw new NotFoundHttpException('Subcategory not found.');
            }
        }

        return $this->render('view', [
            'model' => $model,
            'view' => $view,
            'isUpdate' => $isUpdate,
            'subcategory' => $subcategory,
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


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->set('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => 'Category successfully updated!.',
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
        }

        $subcategory = new Subcategory();
        $subcategoriesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id])->orderBy(['is_deleted' => SORT_ASC]),
        ]);
        $view = true;
        $isUpdate = true;

        return $this->render('view', [
            'model' => $model,
            'view' => $view,
            'isUpdate' => $isUpdate,
            'subcategory' => $subcategory,
            'subcategoriesDataProvider' => $subcategoriesDataProvider,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($id) {
            $model = $this->findModel($id);
            if ($model) {
                if ($model->is_deleted == true) {
                    $model->is_deleted = 0;
                    if ($model->save()) {
                        foreach ($model->subcategories as $subcategory) {
                            $subcategory->is_deleted = 0;
                            $subcategory->save();
                        }
                        Yii::$app->session->set('alert', [
                            'type' => 'success',
                            'title' => 'Success!',
                            'message' => 'Category successfully enabled.',
                        ]);
                    }
                } else {
                    $model->is_deleted = 1;
                    if ($model->save()) {
                        foreach ($model->subcategories as $subcategory) {
                            $subcategory->is_deleted = 1;
                            $subcategory->save();
                        }
                        Yii::$app->session->set('alert', [
                            'type' => 'success',
                            'title' => 'Success!',
                            'message' => 'Category successfully disabled.',
                        ]);
                    }
                }
            }
        } else {
            Yii::$app->session->set('alert', [
                'type' => 'danger',
                'title' => 'Error!',
                'message' => 'An error occurred.',
            ]);
        }

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
