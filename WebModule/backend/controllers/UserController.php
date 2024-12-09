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

class UserController extends Controller
{
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

        $query = User::find();

        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($currentUser->id);

        $roleNames = array_keys($roles);

        if (in_array('Admin', $roleNames)) {
            $query->all();
        } elseif (in_array('Manager', $roleNames)) {
            $query->leftJoin('stations', 'stations.manager_id = :managerId')
                ->leftJoin('station_users', 'station_users.station_id = stations.id')
                ->where([
                    'or',
                    ['user.id' => $currentUser->id],
                    ['user.id' => new \yii\db\Expression('station_users.user_id')]
                ])
                ->addParams([':managerId' => $currentUser->id]);
        } else {
            $query->where(['user.id' => $currentUser->id]);
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

        $model = User::findOne($id);
        $auth = Yii::$app->authManager;
        $roles = $auth->getRolesByUser($model->id);
        $role = !empty($roles) ? implode(', ', array_keys($roles)) : 'No Role';

        return $this->render('view', [
            'model' => $model,
            'role' => $role,
        ]);
    }

    public function actionCreate()
    {
        $model = new UserForm();
        $model->load(Yii::$app->request->post());
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Usuário criado com sucesso.');
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

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

        if ($userForm->load(Yii::$app->request->post())/*  && $userForm->validate()*/) {

            $userForm->save();

            $user->attributes = $userForm->userAttributes();

            $userInfo->attributes = $userForm->userInfoAttributes();
            $userInfo->user_id = $user->id;

            $user->username = $userForm->username;
            $user->email = $userForm->email;

            $userInfo->phone = $userForm->phone;
            $userInfo->name = $userForm->name;
            $userInfo->nif = $userForm->nif;
            $userInfo->address = $userForm->address;
            $userInfo->postal_code = $userForm->postal_code;

            $userInfo->is_deleted = 0;
            $userInfo->is_banned = 0;

            $userInfo->save();
            $user->save();

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($user->save() && $userInfo->save()) {
                    $auth = Yii::$app->authManager;
                    $roles = $auth->getRolesByUser($user->id);
                    $auth->revokeAll($user->id);
                    if (!empty($roles)) {
                        $role = reset($roles);
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

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model) {
            if ($model->userInfo->is_deleted == false) {
                $model->userInfo->is_deleted = 1;
                Yii::$app->session->setFlash('success', 'User succefully disabled');
            } else {
                $model->userInfo->is_deleted = 0;
                Yii::$app->session->setFlash('success', 'User succefully enabled');
            }

            if (!$model->userInfo->save()) {
                Yii::$app->session->setFlash('error', 'An error ocurred trying save user');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ca\'nt find user');
        }
        return $this->redirect(['index']);
    }

    public function actionBan($id)
    {
        $model = $this->findModel($id);

        if ($model) {
            if ($model->userInfo->is_banned == false) {
                $model->userInfo->is_banned = 1;
                Yii::$app->session->setFlash('success', 'User succefully banned');
            } else {
                $model->userInfo->is_banned = 0;
                Yii::$app->session->setFlash('success', 'User succefully banned');
            }

            if (!$model->userInfo->save()) {
                Yii::$app->session->setFlash('error', 'An error ocurred trying save user');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ca\'nt find user');
        }
        return $this->redirect(['index']);
    }

    public function actionChangerole()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $userId = Yii::$app->request->post('user_id');
        $newRole = Yii::$app->request->post('role');

        $auth = Yii::$app->authManager;

        if ($userId && $newRole) {
            $user = User::findOne($userId);
            $auth->revokeAll($userId);
            $role = $auth->getRole($newRole);
            if ($role) {
                Yii::$app->session->set('alert', [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'Invalid Role.',
                ]);
            }
            $auth->assign($role, $userId);
            Yii::$app->session->set('alert', [
                'type' => 'success',
                'title' => 'Success!',
                'message' => $user->userInfo->name . '\'s role has been changed',
            ]);
        }
    }

    public function actionResetPassword($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('O usuário não foi encontrado.');
        }

        $defaultPassword = 'password';

        $user->setPassword($defaultPassword);

        if ($user->save(false)) {
            Yii::$app->session->setFlash('success', 'A senha foi redefinida com sucesso.');
        } else {
            Yii::$app->session->setFlash('error', 'Erro ao redefinir a senha.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
