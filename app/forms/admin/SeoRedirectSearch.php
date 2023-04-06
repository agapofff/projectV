<?php

namespace app\forms\admin;

use app\entities\admin\SeoRedirect;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property int id
 * @property string type
 * @property string url_from
 * @property string url_to
 * @property string created_at
 * @property string updated_at
 */
class SeoRedirectSearch extends Model
{
    public $id;
    public $type;
    public $url_from;
    public $url_to;

    public function rules()
    {
        return [
            [['id', 'type', 'url_from', 'url_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = SeoRedirect::find();
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
            'attributes' => [
                'id',
                'type',
                'url_from',
                'url_to',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['=', 'type', $this->type])
            ->andFilterWhere(['like', 'url_from', $this->url_from])
            ->andFilterWhere(['like', 'url_to', $this->url_to]);

        return $dataProvider;
    }

    public static function getTypeList()
    {
        return [
            0 => Yii::t('admin', 'Обычный редирект'),
            1 => Yii::t('admin', 'Сокращатель ссылок'),
        ];
    }
}
