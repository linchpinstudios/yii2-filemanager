<?php

namespace linchpinstudios\filemanager\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use linchpinstudios\filemanager\models\Files;

/**
 * FilesSearch represents the model behind the search form about `linchpinstudios\filemanager\models\Files`.
 */
class FilesSearch extends Files
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'width', 'height'], 'integer'],
            [['url', 'file_name', 'type', 'title', 'size', 'date', 'date_gmt', 'update', 'update_gmt'], 'safe'],
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
        $query = Files::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'height' => $this->height,
            'date' => $this->date,
            'date_gmt' => $this->date_gmt,
            'update' => $this->update,
            'update_gmt' => $this->update_gmt,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'size', $this->size]);

        return $dataProvider;
    }
}
