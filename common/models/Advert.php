<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "advert".
 *
 * @property integer $idadvert
 * @property integer $price
 * @property string $address
 * @property integer $id_user
 * @property integer $bedroom
 * @property integer $livinroom
 * @property integer $parking
 * @property integer $kitchen
 * @property string $general_image
 * @property string $description
 * @property string $location
 * @property integer $hot
 * @property integer $sold
 * @property string $type
 * @property integer $recommend
 * @property integer $created_at
 * @property integer $updated_at
 */
class Advert extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'advert';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'required'],
            [['price', 'id_user', 'bedroom', 'livinroom', 'parking', 'kitchen', 'hot', 'sold', 'recommend'], 'integer'],
            [['description'], 'string'],
            [['address'], 'string', 'max' => 255],
            [['location'], 'string', 'max' => 50],
          //  [['general_image'], 'file', 'extensions' => ['jpg', 'png', 'gif']],

        ];
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function scenarios() // Так как при загрузки картинки на нет необходимости првоерять все остальные поля которые были на шщаге 1 , создаём сценарий
    {
        $scenarios = parent::scenarios();
        $scenarios['step2'] = ['general_image'];

        return $scenarios;
    }

    public function getUser() //Связываем таблицы
    {
        return $this->hasOne(Myuser::className(),['iduser' => 'id_user']); // Связываем таблицу Myuser поля Id с таблицей advert полем id_user
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idadvert' => 'Idadvert',
            'price' => 'Price',
            'address' => 'Address',
            'id_user' => 'Id user',
            'bedroom' => 'Bedroom',
            'livinroom' => 'Livinroom',
            'parking' => 'Parking',
            'kitchen' => 'Kitchen',
            'general_image' => 'General Image',
            'description' => 'Description',
            'location' => 'Location',
            'hot' => 'Hot',
            'sold' => 'Sold',
            'type' => 'Type',
            'recommend' => 'Recommend',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function afterValidate(){ //необходимо запомнить id пользователя который добавил квартиру. Т.к. каждая квартира привязана к конкретному пользователю.
        $this->id_user = Yii::$app->user->identity->id; // Это поле в котором содержится id пользователя который добавил квартиру.
    }
    public function afterSave($insert, $changedAttributes)// после того как данные сохранились в БД . Мы получаем id записи и сохраняем её в сессию
    { //или все это можно сохранять в КЭШ
      //  Yii::$app->session->set('id',$this->id); //сессия
        Yii::$app->locator->cache->set('id',$this->idadvert);//через КЭШ
    }
}
