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
        $inchargeCount = 0;
        $employeeCount = 0;
        $invoiceByState = [
            2 => 0,
            3 => 0,
            4 => 0,
        ];
        $stationUserCounts = [];
        $userRoleCounts = [];
        $invoiceByStation = [];
        $items = 0;
        $invoiceCount = 0;
        $usersCount = 0;
        $stationId = Yii::$app->request->post('stationId') ?? Yii::$app->request->get('stationId');

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
                foreach ($invoiceCounts as $count) {
                    $invoiceByStation[$count['station_id']] = $count['count'];
                }
                break;
            case 'Manager':
                $role = 'Manager';
                $stations = Station::find()->where(['manager_id' => $currentUser->id])->all();

                if ($stationId) {
                    $userIds = (new \yii\db\Query())
                        ->select('user_id')
                        ->from('station_users')
                        ->where(['station_id' => $stationId])
                        ->column(); // Retorna um array com os IDs

                    if (!empty($userIds)) {
                        $inchargeCount = (new \yii\db\Query())
                            ->from('auth_assignment')
                            ->where(['item_name' => 'Incharge'])
                            ->andWhere(['user_id' => $userIds])
                            ->count();

                        $employeeCount = (new \yii\db\Query())
                            ->from('auth_assignment')
                            ->where(['item_name' => 'Employee'])
                            ->andWhere(['user_id' => $userIds])
                            ->count();
                    } else {
                        $inchargeCount = 0;
                        $employeeCount = 0;
                    }

                    $invoiceStates = (new \yii\db\Query())
                        ->select(['state_id', 'count' => 'COUNT(*)'])
                        ->from('invoices')
                        ->where(['station_id' => $stationId])
                        ->groupBy('state_id')
                        ->all();

                    foreach ($invoiceStates as $state) {
                        $invoiceByState[$state['state_id']] = $state['count'];
                    }
                } else {
                    $dataProvider = new \yii\data\ArrayDataProvider([
                        'allModels' => [],
                    ]);
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
                'role' => $role,
                'userRoleCounts' => $userRoleCounts,
                'usersCount' => $usersCount,
                'stations' => $stations,
                'stationUserCounts' => $stationUserCounts,
                'invoiceCount' => $invoiceCount,
                'stationCount' => $stationCount,
                'invoiceByStation' => $invoiceByStation,

                'inchargeCount' => $inchargeCount,
                'employeeCount' => $employeeCount,
                'invoiceByState' => $invoiceByState,
                'items' => $items,
                'stationId' => $stationId,
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
