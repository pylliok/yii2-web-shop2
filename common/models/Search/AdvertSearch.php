<?php

namespace common\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advert;

/**
 * AdvertSearch represents the model behind the search form about `common\models\Advert`.
 */
class AdvertSearch extends Advert
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idadvert', 'price', 'id_user', 'bedroom', 'livinroom', 'parking', 'kitchen', 'hot', 'sold', 'recommend', 'created_at', 'updated_at'], 'integer'],
            [['address', 'general_image', 'description', 'location', 'type'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Advert::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'idadvert' => $this->idadvert,
            'price' => $this->price,
            'id_user' => $this->id_user,
            'bedroom' => $this->bedroom,
            'livinroom' => $this->livinroom,
            'parking' => $this->parking,
            'kitchen' => $this->kitchen,
            'hot' => $this->hot,
            'sold' => $this->sold,
            'recommend' => $this->recommend,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'general_image', $this->general_image])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
