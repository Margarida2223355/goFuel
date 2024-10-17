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

    public function actionIndex()
    {
        $currentUser = Yii::$app->user->identity;

        if (!$currentUser) {
            throw new \yii\web\ForbiddenHttpException('O usuário logado não possui permissão para visualizar esta página.');
        }

        // Inicialize a consulta do User com junção com UserInfo
        $query = User::find()->joinWith('userInfo');

        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($currentUser->id);

        $roleNames = array_keys($roles);
        if (in_array('Admin', $roleNames)) {
            // Admin pode ver Admins e Managers
            $query->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => ['Admin', 'Manager']]);
        } elseif (in_array('Manager', $roleNames)) {
            // Manager pode ver In Charge e Employees
            $query->innerJoin('auth_assignment', 'auth_assignment.user_id = user.id')
                ->where(['auth_assignment.item_name' => ['In Charge', 'Employee']]);
        } else {
            // Para qualquer outra role, não deve ver nada
            $query->where('0=1');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }




    public function actionView($id)
    {

        $model = UserInfo::findOne(['user_id' => $this->findModel($id)]);
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($model->id);
        $role = !empty($roles) ? implode(', ', array_keys($roles)) : 'No Role';

        return $this->render('view', [
            'model' => $model,
            'role' => $role,
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
        $model->load(Yii::$app->request->post());
        if (/*$model->load(Yii::$app->request->post()) &&*/$model->save()) {
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
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('O usuário não foi encontrado.');
        }

        $userInfo = $user->userInfo;
        if (!$userInfo) {
            throw new NotFoundHttpException('As informações do usuário não foram encontradas.');
        }

        $userForm = new UserForm();
        $userForm->loadUser($user);
        $userForm->loadUserInfo($userInfo);

        if ($userForm->load(Yii::$app->request->post()) && $userForm->validate()) {
            $user->attributes = $userForm->attributes;
            $userInfo->attributes = $userForm->attributes;

            // Inicia uma transação
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user->save(false) && $userInfo->save(false)) {
                    $auth = Yii::$app->authManager;
                    $auth->revokeAll($user->id);
                    $role = $auth->getRole($userForm->role);
                    if ($role) {
                        $auth->assign($role, $user->id);
                    }
                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $user->id]);
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('update', [
            'model' => $userForm,
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
