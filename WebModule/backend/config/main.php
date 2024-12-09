<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'backend-app',
    'basePath' => dirname(__DIR__),
    'name' => 'GoFuel',
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'app\modules\api\ModuleAPI',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 3600,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager', // Usando o DbManager para RBAC
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [

                // Stations
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/station',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Pumps
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/pump',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Items
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/item',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Categories
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/category',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Subcategories
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/subcategory',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Invoices
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/invoice',
                    'extraPatterns' => [
                        'GET userinvoices' => 'get-user-invoices',
                        'GET paidinvoices' => 'get-paid-invoices',
                        'GET pendentinvoices' => 'get-pendent-invoices',
                    ],
                    'tokens' => []
                ],

                // Invoice Lines
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/invoiceline',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Invoice States
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/invoicestate',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // User Infos
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/userinfo',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Users
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/user',
                    'extraPatterns' => [
                        'GET login' => 'login',
                    ],
                    'tokens' => []
                ],

                // Station Items
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/station-item',
                    'extraPatterns' => [],
                    'tokens' => []
                ],

                // Favorite Stations
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/client-station',
                    'extraPatterns' => [],
                    'tokens' => []
                ],
            ],
        ],
    ],
    'params' => $params,
];
