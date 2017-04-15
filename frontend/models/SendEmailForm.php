<?php
namespace frontend\models;
use common\models\Myuser;
use Yii;
use yii\base\Model;

class SendEmailForm extends Model
{
    //публичное свойство которые будет использоваться в форме
    public $email;

    //и правила для свойства Email

    public function rules()
    {
        return
            [
                //Убрать пробелы по краям
                ['email','filter','filter'=> 'trim'],
                ['email','required'],
                ['email','email'],
                ['email', 'exist',
                    'targetClass' => Myuser::className(),//проверяет поле в данном классе
                    'filter' => [
                        'status' => Myuser::STATUS_ACTIVE
                    ],
                    'message' => 'Danni email ne zaregistrirovan',
                ], // данный емаил должен быть в табьлицу Myuser и пользователь с этим email должен быть активирован
            ];
    }

    public function attributeLabels()
    {
        return
            [
                'email' => 'Email pole',
            ];
    }
    //находит пользователя с введённым адресом и записывает секретный ключ
    // и отправляет письмо с ссылкой для смены пароля
    public function sendEmail()
    {
        //свойство User это объект модели Myuser
        /* @var $user Myuser  */
        //найти активированного пользователя с данным емаил
        $user = Myuser::findOne(
            [
                'status' => Myuser::STATUS_ACTIVE,
                'email' => $this->email,
            ]
        );
        //если пользователь неайден
        if($user):
            //создаём и присваивыем пользователю секретный ключ

            $user->generateSecretKey();
           // $user->generatePasswordResetToken(); // изменил 11.04.2017
            //сохраняем в БД. Если всё выполнено отправляем письмо
            if($user->save()):
                //здесь отправка
                return Yii::$app->mailer->compose('resetPassword',['user' => $user])
                    //отпралено о ткого
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name.'(Otpravleno robotom)'])
                    //отправить кому
                    ->setTo($this->email)
                    //тема письма
                    ->setSubject('Sbros parolya'.Yii::$app->name)
                    ->send();
            endif;
        endif;
        //если ниче не выполнено
        return false;
    }
}