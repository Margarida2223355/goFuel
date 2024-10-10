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
     * Lists all Category models.
     *
     * @return string
     */
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

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */


    public function actionView($id)
    {
        // Carregar o modelo da categoria com base no ID
        $model = $this->findModel($id);

        // Criar um novo modelo de Subcategory para o formulário de adição
        $newSubcategory = new Subcategory();

        // Se o formulário da categoria for submetido e os dados forem válidos, salve a categoria
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Category updated successfully!');
            return $this->refresh(); // Recarregar a página para exibir as mudanças
        }

        // Carregar as subcategorias associadas à categoria
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


    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Category();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /*
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
    */
    
     public function actionUpdate($id)
    {
        // Carrega o modelo da categoria que será atualizado
        $model = $this->findModel($id);

        // Criar um novo modelo de Subcategory para o formulário de adição de subcategorias
        $newSubcategory = new Subcategory();

        // Se o formulário da categoria for submetido e os dados forem válidos, salva a categoria
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Category updated successfully!');
            return $this->redirect(['view', 'id' => $model->id]);  // Mantém a mesma página (view)
        }

        // Carregar as subcategorias associadas à categoria
        $subcategoriesDataProvider = new \yii\data\ActiveDataProvider([
            'query' => Subcategory::find()->where(['category_id' => $id]),
        ]);

        // Renderizar a view com o formulário de categoria e a tabela de subcategorias
        return $this->render('view', [
            'model' => $model,
            'newSubcategory' => $newSubcategory,
            'subcategoriesDataProvider' => $subcategoriesDataProvider,
        ]);
    }


    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
