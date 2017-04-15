<?php

namespace frontend\modules\user;

/**
 * user module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setLayoutPath('@frontend/views/layouts');// указываем нашемо модулю где искать layout
        // custom initialization code goes here
    }
}
