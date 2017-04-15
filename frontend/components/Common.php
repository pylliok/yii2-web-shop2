<?

namespace frontend\components;
use yii\base\Component;
use yii\helpers\Url;
use yii\helpers\BaseFileHelper;
class Common extends Component {

    //показываем как создаётся событие и обработчики к нему в yii2

    // 1) Создаётся константа этого собатия
    // например когды мы отправляем письмо это событие оповещает админа о том что было отправлено письмо с сайта
    const EVENT_NOTIFY = 'notify_admin';

    const EVENT_GO = "my_event";

    public function go_event(){
        $this->trigger(self::EVENT_GO);
    }
    public function obrabotchik_go_event($event){
        print "Hello I'm obrabotchik go_event";
    }

    public function sendMail($subject,$text,$dop,$email='sdfsdfsdf.sdfsdf.99@bk.ru',$name='Sergey') //тут почта кому отправляем
    { //статичный метод не имеет доступа к обычным методоам
        $text = 'Komy: '.$dop[0].'</br> Name: '.$dop[1].'</br>'.$text; // тут dop[0] кто отправил
        if(\Yii::$app->mail->compose()
            //  ->setFrom([ \Yii::$app->params['supportEmail'] => \yii::$app->name])
            ->setFrom(['pyiiiok1@ya.ru' => 'Sergey1']) //тот же самый адрес по которому авторизуемся (тот кто отправляет почта сайта)
            ->setTo(/*[$email => $name]*/$dop[0]) //в $dop[0] содержится нужный email кому отправляем
            ->setSubject($subject)
            ->setHtmlBody($text)
            ->send()) {

            // 2) Нужно активизировать это событие через триггер в нем передаём имя события

         //   $this->trigger(self::EVENT_NOTIFY);
            return true;
        }
    }




    public function notifyAdmin($event){

        print "Notify Admin Opoveshenie<br/>";
    }

    public static function getTitleAdvert($data) //подобие заголовка т.к. title в БД не содержится (static Позволяет вызвать Имякласса::метод удобно)
    {
        return $data['bedroom'].' Спальная комната и ' .$data['kitchen']. ' кухня в квартире';
    }

     public static function getImageAdvert($data,$general = true, $original=false) // эти картинки выводим на главнйо в виде фона
     { //функции делаем в maindefaultcontroller и в head меняем вся fe/view common head
          $image=[];
          $base = Url::base(); //базовый путь до картинки

          if($original)
          {
              $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/'.$data['general_image']; //строим путь
          } else
          {
              $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/small_'.$data['general_image'];
          }
          return $image;
     }

 /*  public static function getImageAdvert($data,$general = true,$original = false){ //моя переделанная

        $image = [];
        $base = '/';
        if($general){

            $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/general/general.jpg';
        }
        else{
            $path = \Yii::getAlias("@frontend/web/uploads/adverts/".$data['idadvert']);
            $files = BaseFileHelper::findFiles($path);//передаём полный путь до директории к нашим фоткам

            foreach($files as $file){
                if (//strstr($file, "small_") && !strstr($file, "general")) {
                    //  $image[] = $base . 'uploads/adverts/' . $data['idadvert'] . '/' . basename($file);
                    $image[] = $base.'uploads/adverts/'.$data['idadvert'].'/'.basename($file);
                }
            }
        }

        return $image;
    }*/

    public function substr($data,$start=0,$end=50) //Обрезаем description
    {
        //mb_substr() Можно его использовать мульти байтовай работа с разными типами строк
        return substr($data,$start,$end);//Обрезаем текс от 0 й буквы до 50
    }

    public static function getType($row)
    {
        return ($row['sold']) ? 'Sold' : 'New'; //после вопроса тру если и после : false если
    }


}