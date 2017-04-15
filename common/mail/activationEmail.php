<?php

/* @var $user \common\models\Myuser */
use yii\helpers\Html;


//создаЄм письмо с одной строкой ->ссылка дл¤ активации

echo 'Hi '.Html::encode($user->name).'.</br>';
echo Html::a('Dlya activacii pereidite po ssilke.',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/main/main/account-activation',
            'key' => $user->secret_key,
        ]


    ));
//ссылка с ключем перейд¤ по которой пользователь приведет в действие ActiveAccaunt контроллера
//main и через $_GET передаст секретный ключ $key . ƒействие сделаем поже