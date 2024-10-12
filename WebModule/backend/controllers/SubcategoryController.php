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
    // Outros métodos

    public function actionCreate()
    {
        $model = new Subcategory();

        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();
            if (isset($data['Subcategory']['id'])) {
                // Atualizar
                $model = Subcategory::findOne($data['Subcategory']['id']);
                if ($model) {
                    $model->description = $data['Subcategory']['description'];
                    if ($model->save()) {
                        return $this->redirect(['category/view', 'id' => $model->category_id]);
                    }
                }
            } else {
                // Criar
                $model->load($data);
                if ($model->save()) {
                    return $this->redirect(['category/view', 'id' => $model->category_id]);
                }
            }
        }

        // Caso não seja POST, renderiza a view com o model vazio ou existente
        return $this->render('view', [
            'model' => $model,
        ]);
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
            // Passar o modelo da categoria e outros dados necessários
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id); // Verifica se a subcategoria existe
        $categoryId = $model->category_id; // Guarda o ID da categoria associada

        // Deleta a subcategoria
        if ($model->delete()) {
            // Redireciona para a view da categoria após a exclusão
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

    // Outros métodos
}
