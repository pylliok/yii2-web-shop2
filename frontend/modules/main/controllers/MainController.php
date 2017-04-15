<?php

namespace app\modules\main\controllers;
use common\models\Myuser;
use frontend\components\Common;
use frontend\models\ContactForm;
use frontend\models\LoginForm;
use frontend\models\RegisterForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SendEmailForm;
use Yii;
use yii\base\ErrorException;
use yii\base\InvalidParamException;
use yii\debug\models\search\Log;
//для активации
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\AccountActivation;
use yii\web\BadRequestHttpException;

class MainController extends \yii\web\Controller
{
    public $layout = 'inner';
    //public $layout = 'bootstrap'; // это для всех вьющек использовать данный лейоут
    // main используем для других вещей поэтому лейоут в дефаулт пишем

    /*public function behaviors()
    {
        return [
            'access' => [ //настройки прав доступа пользователей
                'class' => AccessControl::className(),
                'only' => ['login','register'],//используется для данных  actions
                'rules' => [
                    // deny all POST requests
                    [
                        'allow' => false, //не могут выполнять действие
                        'controllers' => ['/main/main/MainController'],
                        'verbs' => ['POST']
                    ],
                    // allow authenticated users
                    [
                        'allow' => true,//могут выполнять действие
                        'controllers' => ['/main/main/MainController'],
                        'roles' => ['@'],//только авторизованные пользователя
                                    //['?'] Только гости
                    ],
                    // everything else is denied
                ],
            ],
        ];
    }
*/






    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // замена Layout для error
            if ($action->id=='error') $this->layout ='inner';
            return true;
        } else {
            return false;
        }
    }




    public function actions(){ //здесь цепляются ations

        return [
            'error' => [ //для вывода ошибки Found 404
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [ //Любое имя можн описать
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                //  'height' => 50,

            ],
        ];
    }


    public function actionLogout() //выход из профиля (Разработанная Yii)
    {
        Yii::$app->user->logout();

        return $this->goHome(); //гланая страница проекта
    }



    public function actionRegister()
    {
        //  $model = new RegisterForm();
        $model = Yii::$app->params['emailActivation'] ? new RegisterForm(['scenario' => 'emailActivation']) : new RegisterForm();

        if($model->load(Yii::$app->request->post()) && $model->goreg())
        {
            Yii::$app->session->setFlash('success','Registe good111');
            if($model->status === Myuser::STATUS_ACTIVE){}
            else
            {
                //пробуем отправить письмо с ключём
                if($model->sendActivationEmail(/*$model*/)):
                    //если отправлено выводим сообщение об успехе
                    Yii::$app->session->setFlash('success','Pismo otpravleno na emain <strong>'.Html::encode($model->email).'</strong>');
                else:
                    Yii::$app->session->setFlash('success','Owibka otpravki pisma');
                endif;
            }
            return $this->refresh();
        }
        return $this->render('register',
            [
                'model' => $model
            ]);
    }
    public function actionLogin(){ //метоод входа

        //    $model = new LoginForm();
        if(!Yii::$app->user->isGuest)  return $this->goHome(); //нельзя залогиниться исли уже залогинен

        $loginWithEmail = Yii::$app->params['loginWithEmail']; //помещаем значение из параметра (true)
        $model = $loginWithEmail ? new LoginForm(['scenario' => 'loginWithEmail']) : new LoginForm();

        if($model->load(\Yii::$app->request->post()) && $model->login()){

            $this->goBack(); //возвращает на ту же страницу с которой мы перешли на форму логина
        }

        return $this->render('login',[
            'model' => $model

        ]);
    }

    public function actionContact(){//форма обратнйо связи

        $model = new ContactForm();
        if($model->load(\Yii::$app->request->post())&& $model->validate()){

            $dop = array();
            $dop[0]= $model->email;
            $dop[1] = $model->name;
            Common::sendMail($model->subject,$model->body,$dop);
            Yii::$app->session->setFlash('success','Pismo yspewno otpravleno');

            return $this->refresh();
        }
        return $this->render('contact',[

            'model' => $model
        ]);
    }

    //создаём действи когда пользователь перейдет по ссылке
    //в ссылке передаётся $key  с секретным ключём
    public function actionAccountActivation(/*$key*/) //если здесь принимаем key то ошибка на английском что нету Key
    {
        $key = Yii::$app->request->get('key');
        try
        {
            //сохдаём новый объект activateaccount , перед созданием вызывается конструктор и проверяет на ошибки
            //если ошибка вызывается InvalidParamExeption
            $user = new AccountActivation($key);
        }
        catch(InvalidParamException $e)//если есть исключение
        {
            // вызываем исключение badrequest (плохой запрос Код 400) с сообщением ислючения
            // InvalidParamExeption из AccountActivation
            throw new BadRequestHttpException($e->getMessage());
        }

        //если объект был создан
        if($user->activateAccount())://активируем пользователя
            Yii::$app->session->setFlash('success','Aktivaciya yspewna');
            return $this->redirect(Url::to(['/main/main/login'])); //делаем переход на страницу входа
        else: //активация не прошла

            Yii::$app->session->setFlash('success','Owiblka aktivacii');
            Yii::error('Owiblka aktivacii');
        endif;
        return $this->redirect(Url::to(['/main/main/login'])); //делаем переход на страницу входа

    }

    public function actionSendEmail()
    {
        $model = new SendEmailForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->sendEmail()):
                    // Yii::$app->getSession()->setFlash('warning','Prover email');
                    Yii::$app->session->setFlash('success','Proverte email');
                    return $this->goHome();
                else:
                    // Yii::$app->getSession()->setFlash('error','Nelzya sbrosit parol');
                    Yii::$app->session->setFlash('success','Nelzya sbrosit parol');
                endif;
            }
        }

        return $this->render('sendEmail', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword()
    {
        $key = Yii::$app->request->get('key');
        try{
            //вот тут в модель передаём ключ надо подумать!
            $model = new ResetPasswordForm($key);
        }
        catch(InvalidParamException $e){
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post())) {
            //в условие с валидацией добавляем условие записи нового пароля и удаление ключа
            if ($model->validate() && $model->resetPassword()) {
                //Yii::$app->getSession()->setFlash('warning','Parol yspewno imenen');
                Yii::$app->session->setFlash('success','Parol yspewno izmenen');
                return $this->redirect('/main/main/login');
            }
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
