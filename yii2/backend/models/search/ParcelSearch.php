<?php

declare(strict_types=1);

namespace backend\models\search;

use common\helpers\DateHelper;
use common\models\Parcel;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ParcelSearch represents the model behind the search form of `common\models\Parcel`.
 */
class ParcelSearch extends Parcel
{
    public $created_at_range;
    public $updated_at_range;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'status'], 'integer'],
            [['track_number'], 'string'],
            [['created_at_range', 'updated_at_range'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param string|null $formName Form name to be used into `->load()` method.
     */
    public function search(array $params, ?string $formName = null): ActiveDataProvider
    {
        $query = Parcel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id'         => $this->id,
            'status'     => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['ilike', 'track_number', $this->track_number]);

        if (!empty($this->created_at_range)) {
            [$start, $end] = explode(' - ', $this->created_at_range);
            $start = DateHelper::toUtc($start);
            $end = DateHelper::toUtc($end);
            $query->andWhere(['between', 'created_at', $start, $end]);
        }

        if (!empty($this->updated_at_range)) {
            [$start, $end] = explode(' - ', $this->updated_at_range);
            $start = DateHelper::toUtc($start);
            $end = DateHelper::toUtc($end);
            $query->andWhere(['between', 'updated_at', $start, $end]);
        }

        return $dataProvider;
    }
}
