<?php

namespace backend\controllers;

use app\models\UserForm;
use common\models\UserForm as UserModel;
use common\models\User;
use common\models\UserInfo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     *
     * @return string
     */

    public function actionIndex()
    {
        // Obtém o usuário logado
        $currentUser = Yii::$app->user->identity;

        // Verifique se $currentUser está definido
        if (!$currentUser) {
            throw new \yii\web\ForbiddenHttpException('Nenhum usuário está logado.');
        }

        // Verifica se o usuário logado tem um registro em userInfo
        if (!$currentUser->userInfo) {
            throw new \yii\web\ForbiddenHttpException('O usuário logado não possui um registro em user_info.');
        }

        // Obtém o userInfo do usuário logado
        $currentUserInfo = $currentUser->userInfo;

        // Inicializa a query
        $query = User::find()->joinWith('userInfo');

        // Se o usuário logado for Admin, exibe Admins e Managers
        if ($currentUserInfo->role === 'Admin') {
            $query->where(['user_info.role' => ['Admin', 'Manager']]);
        }
        // Se o usuário logado for Manager, exibe In Charge e Employees
        elseif ($currentUserInfo->role === 'Manager') {
            $query->where(['user_info.role' => ['In Charge', 'Employee']]);
        }
        // Para outros roles ou se não for Admin ou Manager
        else {
            $query->where('0=1'); // Não exibe nada
        }

        // DataProvider para a GridView
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        // Renderiza a view com o DataProvider
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Displays a single User model.
     * @param int $id
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function actionView($id)
    {

        $model = UserInfo::findOne(['user_id' => $this->findModel($id)]);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

    public function actionCreate()
    {
        $model = new UserForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Usuário criado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // Carrega o modelo User baseado no ID fornecido
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('O usuário não foi encontrado.');
        }

        // Carrega o modelo UserInfo associado ao User
        $userInfo = $user->userInfo;
        if (!$userInfo) {
            throw new NotFoundHttpException('As informações do usuário não foram encontradas.');
        }

        // Instancia o UserForm
        $userForm = new UserForm();

        // Carrega os dados do User e UserInfo no UserForm
        if ($userForm->load(Yii::$app->request->post())) {
            // Atribui os dados carregados ao modelo User e UserInfo
            $user->attributes = $userForm->userAttributes(); // método que retorna atributos do User
            $userInfo->attributes = $userForm->userInfoAttributes(); // método que retorna atributos do UserInfo

            // Validação para ambos os modelos
            if ($user->validate() && $userInfo->validate()) {
                // Inicia uma transação
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    // Salva o modelo User
                    if ($user->save(false)) {
                        // Salva o modelo UserInfo
                        $userInfo->save(false);
                    }

                    // Comita a transação
                    $transaction->commit();

                    // Redireciona para a página de visualização do usuário atualizado
                    return $this->redirect(['view', 'id' => $user->id]);
                } catch (\Exception $e) {
                    // Rollback em caso de erro
                    $transaction->rollBack();
                    throw $e;
                }
            }
        } else {
            // Preenche o UserForm com os dados atuais
            $userForm->loadUser($user);
            $userForm->loadUserInfo($userInfo);
        }

        // Renderiza o formulário de update
        return $this->render('update', [
            'userForm' => $userForm,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionResetPassword($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('O usuário não foi encontrado.');
        }

        // Define a nova senha padrão
        $defaultPassword = 'SenhaPadrao123'; // Alterar para a senha desejada

        // Redefine a senha
        $user->setPassword($defaultPassword);

        if ($user->save(false)) {
            Yii::$app->session->setFlash('success', 'A senha foi redefinida com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao redefinir a senha.');
        }

        return $this->redirect(['index']); // Redireciona para a lista de usuários
    }
}
