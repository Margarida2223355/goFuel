<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Station;
use common\models\StationItem;
use common\models\StationUser;
use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;


class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return !Yii::$app->user->can('Client');
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $currentUser = Yii::$app->user->identity;

        $roles = $auth->getRolesByUser($currentUser->id);

        $userRoleCounts = [];
        $stationCount = [];
        $stationUserCounts = [];
        $userRoleCounts = [];
        $items = 0;

        switch (reset($roles)->name) {
            case 'Admin';
                $role = 'Admin';
                $allRoles = $auth->getRoles();

                foreach ($allRoles as $roleName => $roleObj) {
                    $userCount = (new \yii\db\Query())
                        ->from('auth_assignment')
                        ->where(['item_name' => $roleName])
                        ->count();

                    $userRoleCounts[$roleName] = $userCount;
                }

                $stations = Station::find()->all();
                $stationCount = Station::find()->where(['manager_id' => $currentUser->id])->count();
                $stationUserCounts = [];

                foreach ($stations as $station) {
                    $userCount = StationUser::find()->where(['station_id' => $station->id])->count();

                    $stationUserCounts[$station->name] = $userCount;
                }
                break;
            case 'Manager':
                $stations = Station::find()->where(['manager_id' => $currentUser->id])->all();
                $role = 'Manager';

                $stationCount = Station::find()->where(['manager_id' => $currentUser->id])->count();
                $stationUserCounts = [];

                foreach ($stations as $station) {
                    $userCount = StationUser::find()->where(['station_id' => $station->id])->count();

                    $stationUserCounts[$station->name] = $userCount;
                }
                break;
            case 'Incharge':
                $role = 'In Charge';
                $items = StationItem::find(['id_station' => $currentUser->stationUsers->station_id])->all();
                $items = new \yii\data\ActiveDataProvider([
                    'query' => StationItem::find(['id_station' => $currentUser->stationUsers->station_id])->all()
                ]);
                break;
            case 'Emploee':
                break;
            case 'Client':

                Yii::$app->user->logout();
                break;
        }

        return $this->render(
            'index',
            [
                'role' => $role,
                'userRoleCounts' => $userRoleCounts,
                'stationUserCounts' => $stationUserCounts,
                'stationCount' => $stationCount,
                'items' => $items,
            ]
        );
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('Client')) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('error', 'You don\'t have access to this website. Please, contact support.');
                return $this->redirect(['site/login']);
            }
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
