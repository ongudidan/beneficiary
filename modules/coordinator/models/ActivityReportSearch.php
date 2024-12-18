<?php

namespace app\modules\coordinator\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\dashboard\models\ActivityReport;

/**
 * ActivityReportSearch represents the model behind the search form of `app\modules\dashboard\models\ActivityReport`.
 */
class ActivityReportSearch extends ActivityReport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'activity_id', 'beneficiary_id', 'usage', 'condition', 'recommendation', 'remarks', 'created_by', 'updated_by'], 'safe'],
            [['created_at', 'updated_at'], 'integer'],
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
        $query = ActivityReport::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'activity_id', $this->activity_id])
            ->andFilterWhere(['like', 'beneficiary_id', $this->beneficiary_id])
            ->andFilterWhere(['like', 'usage', $this->usage])
            ->andFilterWhere(['like', 'condition', $this->condition])
            ->andFilterWhere(['like', 'recommendation', $this->recommendation])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'created_by', $this->created_by])
            ->andFilterWhere(['like', 'updated_by', $this->updated_by]);

        return $dataProvider;
    }
}
