<?php
namespace frontend\models;
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 20.08.2016
 * Time: 5:50
 */


use common\models\Myuser;
use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

//и указываем свойство $name

/* @property string $name */

class AccountActivation extends Model
{
    /* @var $user \common\models\Myuser */

    private $user;
    protected $param;
    //конструктор вызывается арньше создания объекта
    public function __construct($key, $config = [])
    {
        $param = 1;
        //если ключ пустой или не является строкой
        if( empty($key) /*|| is_string($key)*/)
            //вызываем исключение неверног опараметра
            throw new InvalidParamException('Ключ не может быть пустым');
        //находим объект пользователя  по ключу
        $this->user = Myuser::findBySecretKey($key,$param);
        //если объект не найден
        if(!$this->user)
            throw new InvalidParamException('Неверный ключ');
        //вызываем метод из родительского класса
        parent::__construct($config);
    }

    //метод который будет активировать нового пользователя

    public function activateAccount()
    {
        $user = $this->user; //свойство $user это объект пользователя
        $user->status = Myuser::STATUS_ACTIVE; //устанавливаем статус
        //$user->secret_key = Null;//поле Secret_key У пользователя рано Null
        $user->removeSecretKey();
        return $user->save();//сохранить и вернуть объект активированного пользователя
    }
    //создаём геттер который будет возвращать name Активированного пользователя

    public function getUsername()
    {
        $user = $this->user;
        return $user->name;
    }
}