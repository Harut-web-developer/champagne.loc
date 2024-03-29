<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'websocket' => [
            'class' => 'YourNamespace\WebSocketHandler',
            'websocketServer' => 'ws://localhost:8080',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'svsdfbaerbeaomo',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '/' => 'site/login',
                '<controller>/<action:\w+>' => '<controller>/<action>',
                'clients-view/<id:\d+>' => 'ClientsController/actionView',
                'clients-debt/<id:\d+>' => 'ClientsController/actionClientsDebt',
                'route-view/<id:\d+>' => 'RouteController/actionRouteView',
                'route-sort/<id:\d+>' => 'RouteController/actionRouteSort',
            ],
        ],
//        'modules' => [
//            'gridview' =>  [
//                'class' => '\kartik\grid\Module',
//                // other module settings
//            ]
//        ],


    ],    'params' => $params,
];

if (YII_ENV_DEV) {
    // configurtion adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1'],
    ];
}

return $config;
