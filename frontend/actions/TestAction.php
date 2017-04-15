<?

namespace frontend\actions;

use yii\base\Action;

class TestAction extends Action{

    public $viewName = 'index';

    public function run(){ //первым делом запускается данная функция , все что происходит здесь выводится на экран

        return $this->controller->render('@frontend/actions/views/'.$this->viewName);
    }
}
?>