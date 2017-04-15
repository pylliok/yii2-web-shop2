<?

namespace common\cache;

use yii\caching\FileCache;
//FileCache хранится все будет в файлах
class Base64Cache extends FileCache{

    public $cacheFileSuffix = '.base64'; //Делаем свой суффикс по умолчанию bin

    protected function getValue($key) //Срабатывает когда мы возвращаем значения
    {
        $value = base64_decode(parent::getValue($key)); // Берем значение которое к нам приходит и раскодируем
        return $value;
    }

    protected function setValue($key, $value, $duration){ //Срабатывает когда устанавливаем (клич, значение, время на какое хранить)
        $value = base64_encode($value); // Кодируем значение
        parent::setValue($key,$value,$duration); // отдаем закодированное значение базовому классу
    }
// Так же есть 3ий метод очистки значения flushValue

}