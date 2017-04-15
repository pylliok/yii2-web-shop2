<?php

namespace frontend\models;

use Yii;
use yii\base\Model;


class NewsForm extends Model
{
    public $title;
    public $text;
    public $description;
    public $verifyCode;


    public function rules()
    {
        return [

            [['title', 'text', 'description','verifyCode'], 'required' , 'message' => 'Поле не может быть пустым'],
            ['title','string', 'min' => 3 ,'max' => '6', 'tooShort' => 'Минимально 3 символа', 'tooLong' => 'Максимально 6 символов'],
            ['verifyCode', 'captcha', 'captchaAction' => \yii\helpers\Url::to(['site/captcha']) , 'message' => 'Ошибка при вводе'], //будет обращаться к site/captcha
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'text' => 'Текст новости',
            'description' => 'Описание',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */

}
