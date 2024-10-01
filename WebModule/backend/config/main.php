<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
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
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
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

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                
                // Stations
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/station',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Pumps
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/pump',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Items
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/item',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Categories
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/category',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Subcategories
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/subcategory',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Invoices
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/invoice',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],

                // Invoice Lines
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/invoiceline',
                    'extraPatterns' => [

                    ],
                    'tokens' => [

                    ]
                ],
            ],
        ],
    ],
    'params' => $params,
];
