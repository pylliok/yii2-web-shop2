<?php
namespace frontend\models;


use common\models\Myuser;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $name;
    public $password;
    public $rememberMe = true;
    public $email;

    private $user;
    private $status;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'password'], 'required'],
            //если используется данный сценарий то поля Email и password обязательны для заплнения
            [['email', 'password'], 'required' , 'on' => 'loginWithEmail'], //on только при этом сценарии срабатывает
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['loginWithEmail'] = ['password','email'];
        return $scenarios;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    //в атрибут передаётся поле из которого данноая функция вызывается
    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();//вызоф функции и получаем
            if (!$user || !$user->validatePassword($this->password)) { //проверка имя и паароля
                // если при создании объекта был использован данный сценарий то помещаем в field свойство email Иначе username
                $field = ($this->scenario === 'loginWithEmail') ? 'email' : 'name';
                //в ошибку добавляем field чтобы при определении сценария добавлялась определенная ошибка
                $this->addError($attribute, 'Incorrect ' . $field . ' or password.');
            }
            if (!$this->getStatus()) {
                $this->addError($attribute, 'Ne aktivirovanna zapis proidite na pochty');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login() //устанавливает куки на 1 год
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser() //ищем такое имя в бд
    {
        if ($this->user === null) {
            //если используется сценарий loginWithEmail
            if($this->scenario === 'loginWithEmail') :
                //находим пользователя по Email
                $this->user = Myuser::findByEmail($this->email);
            else : //иначе находим по username
                //вызов функции из User
                $this->user = Myuser::findByUsername($this->name);
            endif;
        }

        return $this->user;
    }
    protected function getStatus()
    {
        if ($this->status === null) {
            //вызов функции из User
            if($this->scenario === 'loginWithEmail') :
                $this->status = Myuser::findByStatusEmail($this->email);
            else :
                $this->status = Myuser::findByStatusName($this->name);
            endif;

        }
        return $this->status;
    }

    public function attributeLabels()
    {
        return
            [
                'name' => 'Name',
                'email' => 'email',
                'password' => 'password',
                'rememberMe' => 'rememberMe'

            ];
    }

}
