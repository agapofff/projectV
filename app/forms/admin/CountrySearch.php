<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\entities\admin\Country;
use yii\helpers\ArrayHelper;

class CountrySearch extends Model
{
    public $title;
    public $domain;
    public $iso;
    public $phone_code;
    public $store_id;
    public $lang_id;
    public $currency_iso;
    public $phone_mask;
    public $post_code;
    public $active;

    public function rules()
    {
        return [
            [['title', 'domain', 'iso', 'phone_code', 'store_id', 'lang_id', 'currency_iso', 'active'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Country::find();
 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['title' => SORT_ASC],
            'attributes' => [
                'domain',
                'title',
                'iso',
                'phone_code',
                'store_id',
                'lang_id',
                'currency_iso',
                'phone_mask',
                'post_code',
                'active',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'domain', $this->domain])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['=', 'iso', $this->iso])
            ->andFilterWhere(['=', 'phone_code', $this->phone_code])
            ->andFilterWhere(['=', 'store_id', $this->store_id])
            ->andFilterWhere(['=', 'lang_id', $this->lang_id])
            ->andFilterWhere(['=', 'currency_iso', $this->currency_iso])
            ->andFilterWhere(['=', 'active', $this->active]);

        return $dataProvider;
    }

    public static function getDomain()
    {
        return ArrayHelper::map(Country::find()
            ->distinct('domain')
            ->select('domain')
            ->orderBy('domain')
            ->all(), 'domain', 'domain');
    }

    public static function getStoreId()
    {
        return ArrayHelper::map(
            Country::find()
                ->distinct('store_id')
                ->select('store_id')
                ->orderBy('store_id')
                ->all(),
            'store_id',
            'store_id'
        );
    }

    public static function getLangs()
    {
        return ArrayHelper::map(
            Country::find()->alias('c')
                ->select('c.lang_id as lang_id, l.url as url')
                ->innerJoinWith(['lang l'])
                ->orderBy('l.url')
                ->all(),
            'lang_id',
            'url'
        );
    }

    public static function getCurrencies()
    {
        return ArrayHelper::map(
            Country::find()
                ->distinct('currency_iso')
                ->select('currency_iso')
                ->orderBy('currency_iso')
                ->all(),
            'currency_iso',
            'currency_iso'
        );
    }

    public static function getActive()
    {
        return [
            1 => Yii::t('admin', 'Активно'),
            0 => Yii::t('admin', 'Неактивно'),
        ];
    }
}
