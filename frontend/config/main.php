<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php')
 //   require(__DIR__ . '/params-local.php')
);

return [
    'language' => 'ru-RU',
    'id' => 'app-frontend', //просто название проекта
    'basePath' => dirname(__DIR__), //определяет базовый путь откуда должен идти поиск
    'bootstrap' => ['log'], // можем создавать свои бустрам классы и их передавать и будут раньше всгео подгружены.
    'controllerNamespace' => 'frontend\controllers', //используется для работы autoloading. Т.к. autoloading посмтроен на Namespace. Контроллеры будут искатсья именно тут
    'defaultRoute' => 'main/default/index', //делаем нашу страницу на главную котора¤ щас по адресу main

    'modules' => [
        'main' => [
            'class' => 'app\modules\main\Module',
        ],
        'cabinet' => [
            'class' => 'frontend\modules\cabinet\Module',
        ],
        'user' => [
            'class' => 'frontend\modules\user\Module'
        ],
    ],
	
	

    'components' => [  //Важная. Устанавливаются раличные расширения, библиотеке и тд.

        'mail' => [
            'class'            => 'zyx\phpmailer\Mailer',
            'viewPath'         => '@common/mail', //Шаблонные файлы
            'useFileTransport' => false, //если стоит тру то будет сохраняться локальная копия этого письма в runtime/mail или изменить куда сохранять public $fileTransportPath='' в вендоре
            'config'           => [
                'mailer'     => 'smtp',
                'host'       => 'smtp.yandex.ru',
                'port'       => '465',
                'smtpsecure' => 'ssl',
                'smtpauth'   => true,
                'username'   => 'pyiiiok1@ya.ru', //здесь свои настройки
                'password'   => 'PyIIIoK',		//здесь свои настройки
                'isHtml'     => true, //может передоватьс¤ html
                'charset'    => 'UTF-8',
            ],
			
        ],

        'common'=> [ //вспомогательные функции например phpmailer
            'class' => '\frontend\components\Common',
        ],

        'request' => [
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => ''
        ],
        'user' => [ //Данные ьлок используется для авторизации.
           // 'identityClass' => 'common\models\User',
            'identityClass' => 'common\models\Myuser',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
            'loginUrl' => '/main/main/login', //куда перенаправлять если готь зашел на стр где необходима авторизация
        ],

        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [ //Логирование
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget', //Хранит все логи
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true, //если true Все письма будут сохраняться в runtime/mail
        ],
        'errorHandler' => [  //что и где будет отображаться в ошибочная странице
          //  'errorAction' => 'site/error',
            'errorAction' => 'main/main/error',//Not Found 404

        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],



    ],
    'params' => $params,
];
