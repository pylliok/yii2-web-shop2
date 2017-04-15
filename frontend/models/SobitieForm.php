<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SobitieForm extends Model
{
    public $name;
    public $password;
    public $login;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
 
            ['username', 'required'],
 
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        }
        
      /*  $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;*/
    //}
}
