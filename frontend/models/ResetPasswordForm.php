<?php
namespace frontend\models;

use common\models\Myuser;
use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Ключ не может быть пустым');
        }
        $this->_user = Myuser::findBySecretKey($token,0); // Второй параметр это срок действия ключа может истеч если 1 то бессрочка если 0 то может истеч и заного просить восстановить
        if (!$this->_user) {
            throw new InvalidParamException('Несуществующий ключ');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Resets password.
     *
     * @return bool if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removeSecretKey();
       // $user->removePasswordResetToken();

        return $user->save(false);
    }
}
