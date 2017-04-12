<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\AdminUser',
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
                    'class' => 'yii\log\FileTarget',
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
//            'suffix' => '.html',
            'rules' => [
                '<controller:(post|comment)>s' => "<controller>/index",// '<controller:\w+>s' => "<controller>/index", 所有
                '<controller:\w+>s/<id:\d+>' => "<controller>/view",
                '<controller:\w+-\w+>s/<id:\d+>' => "<controller>/view",
                '<controller:\w+>s/<id:\d+>/<action:create|update|delete>' => "<controller>/<action>",
                '<controller:\w+-\w+>s/<id:\d+>/<action:create|update|delete>' => "<controller>/<action>",
//                '<controller:\w+-\w+>s' => "<controller>/index",
                ///<id:\d+>
            ],
        ],
    ],
    'params' => $params,
];
