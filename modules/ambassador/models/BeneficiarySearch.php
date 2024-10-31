<?php

namespace app\modules\ambassador\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\Beneficiary;

/**
 * BeneficiarySearch represents the model behind the search form of `app\modules\dashboard\models\Beneficiary`.
 */
class BeneficiarySearch extends Beneficiary
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'sub_location_id', 'village_id', 'name', 'national_id', 'contact', 'sub_location', 'village', 'stove_no', 'issue_date', 'lat', 'long', 'created_by', 'updated_by'], 'safe'],
            [['status', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Beneficiary::find();

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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'sub_location_id', $this->sub_location_id])
            ->andFilterWhere(['like', 'village_id', $this->village_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'national_id', $this->national_id])
            ->andFilterWhere(['like', 'contact', $this->contact])
            ->andFilterWhere(['like', 'sub_location', $this->sub_location])
            ->andFilterWhere(['like', 'village', $this->village])
            ->andFilterWhere(['like', 'stove_no', $this->stove_no])
            ->andFilterWhere(['like', 'issue_date', $this->issue_date])
            ->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'long', $this->long])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
