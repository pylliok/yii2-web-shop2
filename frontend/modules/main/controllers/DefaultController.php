<?php

namespace app\modules\main\controllers;

use yii\db\Query;
use yii\web\Controller;

/**
 * Default controller for the `main` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "bootstrap";
        $query = new Query(); //Query объект - построитель запросов
        //Обращаемся в талицу Advert сортируем по убыванию  по idadvert, в количестве 5и записей
        $command = $query->from('advert')->orderBy('idadvert desc')->limit(5);
        //Вытаскиваем все записи
        $result_general = $command->all();
        //Подсчитываем количство записей
        $count_general = $command->count();

        return $this->render('index',
            [
                'result_general' => $result_general,
                'count_general' => $count_general
            ]);
    }
/* // Смотри web/index   d
    public function actionCacheTest()
    {
        $locator =  \Yii::$app->locator;
        $locator->cache->set('test', 1);

        print $locator->cache->get('test');
    }*/
}
