<?php

namespace frontend\modules\user\controllers;

use yii\web\Controller;

/**
 * Default controller for the `user` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
  //  public $layout = 'bootstrap';
    public function actionIndex()
    {

        return $this->render('index');
    }
}
