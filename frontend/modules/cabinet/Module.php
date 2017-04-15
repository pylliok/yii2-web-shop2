<?php

namespace frontend\modules\cabinet;

/**
 * cabinet module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'frontend\modules\cabinet\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        //”станавливаем где брать наш layout

        $this->setLayoutPath('@frontend/views/layouts');
        // custom initialization code goes here
    }
}
