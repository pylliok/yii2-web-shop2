<?php

namespace frontend\controllers;

class WebshopController extends \yii\web\Controller
{
    public $layout = 'webshop';

    public function actionIndex()
    {
        return $this->render('index');
    }

}
