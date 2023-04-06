<?php

namespace app\forms\admin;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\entities\admin\Store;
use yii\helpers\ArrayHelper;

class StoreSearch extends Model
{
    public $id;
    public $type;
    public $title;
    public $currency_iso;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['type', 'title', 'currency_iso'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Store::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 50,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['title' => SORT_ASC, 'type' => SORT_ASC],
            'attributes' => [
                'id',
                'type',
                'title',
                'currency_iso',
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['=', 'id', $this->id])
            ->andFilterWhere(['=', 'type', $this->type])
            ->andFilterWhere(['=', 'title', $this->title])
            ->andFilterWhere(['=', 'currency_iso', $this->currency_iso]);

        return $dataProvider;
    }

    public static function getTitle()
    {
        return ArrayHelper::map(Store::find()
            ->distinct('title')
            ->select('title')
            ->orderBy('title')
            ->all(), 'title', 'title');
    }

    public static function getCurrencyIso()
    {
        return ArrayHelper::map(Store::find()
            ->distinct('currency_iso')
            ->select('currency_iso')
            ->orderBy('currency_iso')
            ->all(), 'currency_iso', 'currency_iso');
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

    public static function getCountries($store): string
    {
        if ($storeInCountries = $store->storeInCountries) {
            $countries = [];
            foreach ($storeInCountries as $storeInCountry) {
                if ($country = $storeInCountry->country) {
                    $title = $country->getLocalTitle();
                    $countries[$title] = '<span class="badge badge-primary">' . $title . ' (' . $country->id . ')</span>';
                }
            }
            sort($countries);

            return '
        <button
            class="btn btn-dark btn-sm"
            type="button" 
            data-toggle="collapse"
            data-target="#country-' . $store->id . '"
            aria-expanded="false"
            aria-controls="country-' . $store->id . '">' . Yii::t('app', 'Информация') . '</button>
        <div class="collapse mt-3" id="country-' . $store->id . '">
            ' . implode('<br>', $countries) . '
        </div>
            ';
        }
        return false;
    }

    public static function getProducts($model)
    {
        $products = [];
        foreach ($model->productsSessia as $val) {
            if ($product = $val->product) {
                $products[$product->sessia_title] = '<span class="badge badge-info" style="text-align: left; white-space: unset;">' . $product->sessia_title . ' (' . $val->id . ')</span>';
            }
        }
        sort($products);

        return '
        <button
            class="btn btn-dark btn-sm"
            type="button" 
            data-toggle="collapse"
            data-target="#product-' . $model->id . '"
            aria-expanded="false"
            aria-controls="product-' . $model->id . '">' . Yii::t('app', 'Информация') . '</button>
        <div class="collapse mt-3" id="product-' . $model->id . '">
            ' . implode('<br>', $products) . '
        </div>
        ';
    }
}
