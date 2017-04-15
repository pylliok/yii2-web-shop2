<?php

namespace frontend\modules\cabinet\controllers;

use common\controllers\AuthController;
use Yii;
use common\models\Advert;
use common\models\Search\AdvertSearch;
use yii\helpers\BaseFileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Imagine\Image\Point;
use yii\imagine\Image;
use Imagine\Image\Box;


/**
 * AdvertController implements the CRUD actions for Advert model.
 */
//class AdvertController extends Controller
class AdvertController extends AuthController //AuthController там написана права доступа к личному кабинету
{

    public $layout = 'inner';

    public function actionIndex()
    {
        $searchModel = new AdvertSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Advert model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Advert model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Advert();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
           // return $this->redirect(['view', 'id' => $model->idadvert]);
            //редирект необходимо теперь делать на Step2
            return $this->redirect(['step2']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Advert model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          //  return $this->redirect(['view', 'id' => $model->idadvert]);
            //редирект необходимо теперь делать на Step2
            return $this->redirect(['step2']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Advert model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Advert model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Advert the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Advert::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStep2() //На первом шаге мы записываем данные в БАЗУ включая id записи
    {
      //  $id =  Yii::$app->session->get('id'); // получаем id записи через сессию
        $id =  Yii::$app->locator->cache->get('id'); // получаем id Через КЭШ
        $model = Advert::findOne($id); // помещаем в модель данные по id
        $image = [];
        if($general_image = $model->general_image) //выводим нашу картинку основную
        {
            $image[] = '<img src="/uploads/adverts/'. $model->idadvert . '/general/small_' . $general_image . '"width=250>'; // Это передаётся в 'initialPreview' (Step2)
        }

        if(Yii::$app->request->isPost){
            $this->redirect(Url::to(['advert/']));
        }

        $path = Yii::getAlias("@frontend/web/uploads/adverts/".$model->idadvert);
        $images_add = [];

        try {
            if(is_dir($path)) {
                $files = \yii\helpers\FileHelper::findFiles($path);

                foreach ($files as $file) {
                    if (strstr($file, "small_") && !strstr($file, "general")) {
                        $images_add[] = '<img src="/uploads/adverts/' . $model->idadvert . '/' . basename($file) . '" width=250>';
                    }
                }
            }
        }
        catch(\yii\base\Exception $e){}


        return $this->render("step2",['model' => $model,'image' => $image, 'images_add' => $images_add]);
    }


    public function actionFileUploadGeneral(){ //Загрузка основной картинки

        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post("advert_id"); // Получаем Этот advert_id из Step2 главной картинки
            $path = Yii::getAlias("@frontend/web/uploads/adverts/".$id."/general"); // Создаём директорию (необходимо самим создать папки web->uploads/adverts)
            // Внутри уже уже будет автоматом создаваться папка с id и в ней папка general
            BaseFileHelper::createDirectory($path); // creatDirectory - он проверяет если есть такая папка возвращает true если нет то создаёт
            $model = Advert::findOne($id); // по id возвращаем данные
            $model->scenario = 'step2'; // говорим с каким сценарием работаем

            $file = UploadedFile::getInstance($model,'general_image'); //UploadedFile для загрузки картинки (Принимает модель и название атребута)
            $name = 'general.'.$file->extension; //изменяем имя загружаемого файла ($file->extension указывает расширение)
            $file->saveAs($path .DIRECTORY_SEPARATOR .$name); //Сохраняем нашу картинку указываем путь и имя (DIRECTORY_SEPARATOR это слеш)

            $image  = $path .DIRECTORY_SEPARATOR .$name;
            $new_name = $path .DIRECTORY_SEPARATOR."small_".$name;

            $model->general_image = $name; //имя сохраняем в базу но можно и не делать
            $model->save();
             // Здесь картинку приводим к нужному виду
            $size = getimagesize($image); //стандартный метод Php
            $width = $size[0];
            $height = $size[1];

            Image::frame($image, 0, '666', 0) //Передаём полный путь до картинки
                ->crop(new Point(0, 0), new Box($width, $height)) //Обрезаем картинку по длине и высоте орегинальные размеры
                ->resize(new Box(1000,644)) //Приводим к нужным размерам
                ->save($new_name, ['quality' => 100]); // и сохраняем даём другое имя small_

            return true;

        }
    }


    public function actionFileUploadImages(){ // Загрузка дополнительных картинок
        if(Yii::$app->request->isPost){
            $id = Yii::$app->request->post("advert_id"); //принимает advert id из Step2
            $path = Yii::getAlias("@frontend/web/uploads/adverts/".$id); //В корень папки сохраняем картинки
            BaseFileHelper::createDirectory($path); //создаём директорию если её нет
            $file = UploadedFile::getInstanceByName('images'); // getInstanceByName - он работает по названию т.к. передаём по имени нет привязки к модели в Step2
            $name = time().'.'.$file->extension; //формируем название от времени
            $file->saveAs($path .DIRECTORY_SEPARATOR .$name); // сораняем

            $image = $path .DIRECTORY_SEPARATOR .$name;
            $new_name = $path .DIRECTORY_SEPARATOR."small_".$name;

            $size = getimagesize($image);
            $width = $size[0];
            $height = $size[1];

            Image::frame($image, 0, '666', 0)
                ->crop(new Point(0, 0), new Box($width, $height))
                ->resize(new Box(1000,644))
                ->save($new_name, ['quality' => 100]);

            sleep(1); // небольшая задерка т.к. можем загружань несколько картинок , если загружать без задержки то может быть ошибка
            return true;

        }
    }

}
