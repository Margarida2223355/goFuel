<?php

namespace backend\controllers;

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

        // Carrega os dados postados no modelo
        if ($model->load(Yii::$app->request->post())) {
            // Tenta salvar a subcategoria no banco de dados
            if ($model->save()) {
                // Se a subcategoria for salva com sucesso, redirecione de volta para a página da categoria
                return $this->redirect(['category/view', 'id' => $model->category_id]);
            }
        }

        // Caso falhe, redireciona para a página de categorias
        return $this->redirect(['category/index']);
    }


    public function actionUpdate($id)
    {
        // Carrega o model existente da subcategoria
        $model = Subcategory::findOne($id);

        if (!$model) {
            throw new NotFoundHttpException('The requested subcategory does not exist.');
        }

        // Processa o envio do formulário
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Subcategory updated successfully.');

            // Redireciona para a página de visualização da categoria (ou outra página relevante)
            return $this->redirect(['category/view', 'id' => $model->category_id]);
        }

        // Se não for enviado, exibe o formulário
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        // Encontra o modelo da subcategoria com base no ID fornecido
        $model = $this->findModel($id);

        // Armazena o ID da categoria associada para redirecionamento
        $categoryId = $model->category_id;

        // Tenta excluir o modelo
        if ($model->delete()) {
            // Redireciona de volta para a página de atualização da categoria
            return $this->redirect(['category/update', 'id' => $categoryId]);
        }
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
