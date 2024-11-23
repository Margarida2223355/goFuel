<?php

namespace app\modules\api\controllers;

use common\models\User;
use common\models\UserInfo;
use yii\rest\ActiveController;
use yii\web\ForbiddenHttpException;
use yii\filters\auth\HttpBasicAuth;

class UserController extends ActiveController
{
    public $modelClass = Userinfo::class;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'auth' => [$this, 'auth']
        ];
        return $behaviors;
    }

    public function auth($username, $password)
    {
        $user = User::findByUsername($username);

        if ($user && $user->validatePassword($password)) {
            $this->user = $user;
            return $user;
        }

        throw new ForbiddenHttpException('403: No authentication');
    }

    public function actionLogin()
    {
        return UserInfo::findOne([
            'id' => $this->user->id
        ]);
    }
}
