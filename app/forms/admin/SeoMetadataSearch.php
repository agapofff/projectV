<?php

namespace app\forms\admin;

use app\entities\admin\SeoMetadata;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property int id
 * @property string link
 * @property string title
 * @property string description
 * @property string h1
 * @property string created_at
 * @property string updated_at
 */
class SeoMetadataSearch extends Model
{
    public $id;
    public $link;
    public $title;
    public $description;
    public $h1;

    public function rules()
    {
        return [
            [['id', 'link', 'title', 'description', 'h1'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = SeoMetadata::find();
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['link' => SORT_ASC],
            'attributes' => [
                'id',
                'link',
                'title',
                'description',
                'h1',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'h1', $this->h1]);

        return $dataProvider;
    }
}
