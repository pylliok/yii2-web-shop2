<?

namespace frontend\validators;

class TypeAdverValidators extends \yii\validators\Validator{


    public function validateAttribute($model, $attribute) //принимает модель и атрибуты все в призентации есть
    {

        $value = $model->$attribute; //получаем значение атрибута
        if(!in_array($value, ['Buy', 'Sale', 'Rent'])){ //проверяем входит ли значение которые получили с перечисленными
        $this->addError($model, $attribute, 'нет такого значения');//если нету то выводим сообщение об ошибке
        }
        parent::validateAttribute($model, $attribute); // TODO: Change the autogenerated stub
    }

}