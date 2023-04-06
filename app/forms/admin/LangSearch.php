<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\entities\lang\Lang;

class LangSearch extends Model
{
    public $id;
    public $url;
    public $iso;
    public $name;
    public $active;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['url', 'iso', 'name', 'active'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Lang::find();
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_ASC],
            'attributes' => [
                'id',
                'url',
                'iso',
                'name',
                'active',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['=', 'url', $this->url])
            ->andFilterWhere(['=', 'iso', $this->iso])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['=', 'active', $this->active]);
 
        return $dataProvider;
    }

    public static function getActive()
    {
        return [
            1 => Yii::t('admin', 'Активно'),
            0 => Yii::t('admin', 'Неактивно'),
        ];
    }

    public static function getActiveText($i)
    {
        $arr = [
            1 => '<i class="active__yes fas fa-check-circle text-success"></i>',
            0 => '<i class="active__no fas fa-times-circle text-danger"></i>',
        ];
        return $arr[$i];
    }
}
