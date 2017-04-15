<?php
/* @var $user \common\models\Myuser */

use yii\helpers\Html;

echo 'Hi '.Html::encode($user->name).'.</br>';
echo Html::a('Dlya smeni parolya pereidite po ssilke',
    Yii::$app->urlManager->createAbsoluteUrl(
        [
            '/main/main/reset-password',
            'key' => $user->secret_key,
           // 'key' => $user->password_reset_token, //изменил 11.04.2017
        ]


    ));