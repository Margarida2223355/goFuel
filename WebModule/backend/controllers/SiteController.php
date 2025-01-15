<?php

namespace backend\controllers;

use common\models\Invoice;
use common\models\LoginForm;
use common\models\Station;
use common\models\StationItem;
use common\models\StationUser;
use common\models\User;
use Yii;
use yii\db\Query;
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
                        'actions' => ['actions'],
                        'allow' => true,
                        'roles' => ['SiteActionsPermission'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['SiteIndexPermission'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['SiteLogoutPermission'],
                    ],
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

        if ($currentUser === null) {
            return $this->redirect(['site/login']);
        }

        $roles = $auth->getRolesByUser($currentUser->id);

        $userRoleCounts = [];
        $stationCount = [];
        $stationUserCounts = [];
        $userRoleCounts = [];
        $items = 0;
        $invoiceCount = 0;
        $usersCount = 0;

        switch (reset($roles)->name) {
            case 'Admin';
                $role = 'Admin';
                $allRoles = $auth->getRoles();
                $usersCount = User::find()->count();

                foreach ($allRoles as $roleName => $roleObj) {
                    $userCount = (new \yii\db\Query())
                        ->from('auth_assignment')
                        ->where(['item_name' => $roleName])
                        ->count();

                    $userRoleCounts[$roleName] = $userCount;
                }

                $stations = Station::find()->all();
                $stationCount = Station::find()->count();
                $invoiceCount = Invoice::find()->count();
                $invoiceCounts = Invoice::find()
                    ->select(['station_id', 'count' => 'COUNT(*)'])
                    ->groupBy('station_id')
                    ->asArray()
                    ->all();
                $invoiceByStation = [];
                foreach ($invoiceCounts as $count) {
                    $invoiceByStation[$count['station_id']] = $count['count'];
                }
                break;
            case 'Manager':
                $role = 'Manager';
                $stations = Station::find()->where(['manager_id' => $currentUser->id])->all();

                $stationCount = Station::find()->where(['manager_id' => $currentUser->id])->count();
                $stationUserCounts = [];

                $stationUserCounts = [];
                $invoiceByStation = [];

                foreach ($stations as $station) {
                    $userIds = (new \yii\db\Query())
                        ->select('user_id')
                        ->from('station_users')
                        ->where(['station_id' => $station->id])
                        ->all();

                    if (!empty($userIds)) {
                        $inchargeCount = (new Query())
                            ->from('auth_assignment')
                            ->where(['item_name' => 'Incharge'])
                            ->andWhere(['user_id' => $userIds])
                            ->count();

                        $employeeCount = (new Query())
                            ->from('auth_assignment')
                            ->where(['item_name' => 'Employee'])
                            ->andWhere(['user_id' => $userIds])
                            ->count();
                    } else {
                        $inchargeCount = 0;
                        $employeeCount = 0;
                    }

                    $invoiceCount = Invoice::find()
                        ->where(['station_id' => $station->id])
                        ->count();

                    $stationUserCounts[$station->name] = [
                        'incharges' => $inchargeCount,
                        'employees' => $employeeCount,
                    ];

                    $invoiceByStation[$station->name] = $invoiceCount;
                }
                break;
            case 'Incharge':
                $role = 'In Charge';
                $items = new \yii\data\ActiveDataProvider([
                    'query' => StationItem::find(['id_station' => $currentUser->stationUsers->station_id])->all()
                ]);
                break;
            case 'Employee':
                $role = 'Employee';
                break;
            case 'Client':
                $role = 'Client';
                break;
        }

        return $this->render(
            'index',
            [
                'items' => $items,
                'role' => $role,
                'userRoleCounts' => $userRoleCounts,
                'usersCount' => $usersCount,
                'stations' => $stations,
                'stationUserCounts' => $stationUserCounts,
                'stationCount' => $stationCount,
                'invoiceCount' => $invoiceCount,
                'invoiceByStation' => $invoiceByStation,
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

        Yii::$app->view->registerLinkTag([
            'rel' => 'icon',
            'type' => 'image/x-icon',
            'href' => Yii::getAlias('@web/img/logo_mini.png'), // Ícone específico para login
        ]);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (Yii::$app->user->can('Client')) {
                Yii::$app->user->logout();
                Yii::$app->session->set('alert', [
                    'type' => 'danger',
                    'title' => 'Error!',
                    'message' => 'You don\'t have access to this website. Please, contact support.',
                ]);
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

        return $this->redirect('login');
    }
}
