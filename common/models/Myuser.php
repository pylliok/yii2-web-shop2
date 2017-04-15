<?php

namespace common\models;
use yii\db\ActiveRecord;
use Yii;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior; //для автоматического добавления времени

/**
 * This is the model class for table "myuser".
 *
 * @property integer $iduser
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $status
 * @property string $secret_key
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 */

class Myuser extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;
   // public $secret_key;
    public $password;
    public $username; /// Добавил

    /**
     * @inheritdoc
     */

    /* public function rules()
     {
        return
            [
                ['secret_key','unique'],
            ];
     }*/
    public function behaviors()//здесь содержаться различные поведения например добавление времениы
    {
        return
            [
                TimestampBehavior::className(),//поыедение времени
            ];
    }

    //ищем Secret_key
    public static function findBySecretKey($key,$param)
    {
        //если метод вернул false возвращаем null
        if(!($param === 1)) //если 1 то активация аккаунта бессрочна (а восстановление пароля !1)
            if(!static::isSecretKeyExpire($key))
                return null;//ошибка
        //иначе находи пользователя и возвращаем данные
        return static::findOne(
            [
                'secret_key' => $key
            ]);
    }


    //получаем колюч и првоеряем что не пустое поле и время еще не истекло (1 час)
    public static function isSecretKeyExpire($key)
    {
        if(empty($key))
            return false;
        //ехпире равно сроку действия ключа
        $expire = Yii::$app->params['secretKeyExpire'];
        //разбиваем строку на массив с разделением '_'
        $parts = explode('_',$key);
        //перемещаем время в меременную timestamp (время)
        $timestamp = (int) end($parts);
        //складываем время создания ключа и время действия ключа , и если полученное значение больше либо равно
        // текущему времени возвращаем true Иначе false т.е. срок действия ключа истек
        return $timestamp + $expire >= time();
    }

    //метод ля поиска пользоваетля по имени
    public static function findByUsername($name) //нвытаскиваем данные по имени
    {
        return static::findOne(['name' => $name]); //находим наше имя в бд
    }
    //проверка на статус Активации если вход по name
    public static function findByStatusName($name)
    {
        return static::findOne(['name' => $name , 'status' => self::STATUS_ACTIVE]); //находим наше имя в бд
    }
    //проверка на статус активации если вход по Email
    public static function findByStatusEmail($email)
    {
        return static::findOne(['email' => $email , 'status' => self::STATUS_ACTIVE]); //находим наше имя в бд
    }

    public static function tableName()
    {
        return 'myuser';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iduser' => 'Iduser',
            'name' => 'Name',
            'password' => 'Password',
            'email' => 'Email',
            'secret_key' => 'Key',
        ];
    }
    //ШИФрует пароль и сохраняет в БД
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
    //используется для чек бокса запомни меня
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    //сарвнивает введённый пасвор с пассвордом из бд
    public function validatePassword($password)
    {

        return Yii::$app->security->validatePassword($password,$this->password_hash);
    }


    public static function findIdentity($id)
    {
        return static::findOne(['iduser' => $id , 'status' => '1']);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    //поиск пользователя по Email
    public static function findByEmail($email)
    {
        return static::findOne(
            [
                'email' => $email
            ]);
    }
    //обнуляем secret_key
    public function removeSecretKey()
    {
        $this->secret_key = null;
    }

    public function generateSecretKey()
    {
        return $this->secret_key = Yii::$app->security->generateRandomString() . '_' . time();
    }
    // Добавил 11.04.2017
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
}
