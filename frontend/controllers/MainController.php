<?php

namespace frontend\controllers;

class MainController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
