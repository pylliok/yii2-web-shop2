<?
namespace frontend\components;

use yii\base\Component;

class debug extends Component {

public function debug_k($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
    die;
}

}
