<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        //подключаем наш файл db.php , его нужно еще и в console main.php подключить
        'db' => require(dirname(__DIR__)."/config/db.php"),

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
