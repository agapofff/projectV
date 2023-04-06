<?php

namespace app\forms\admin;

use app\entities\admin\Country;
use app\entities\lang\Lang;
use app\entities\admin\Product;
use app\repositories\LangTranslatorRepository;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property int id
 * @property string sessia_vendor_code
 * @property string sessia_title
 * @property string sessia_img
 * @property string category
 * @property string collection
 * @property string sex
 * @property string problem
 * @property int position
 * @property string created_at
 * @property string updated_at
 */
class ProductSearch extends Model
{
    public $id;
    public $sessia_vendor_code;
    public $sessia_title;
    public $sessia_img;
    public $category;
    public $collection;
    public $sex;
    public $problem;
    public $position;

    public function rules()
    {
        return [
            [['sessia_vendor_code', 'sessia_title', 'category', 'collection', 'sex', 'problem'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Product::find()->alias('p')
            ->where(['sessia_vendor_code' => Yii::$app->params['vendor_codes']])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 500,
            ],
        ]);

        $dataProvider->setSort([
            'defaultOrder' => ['position' => SORT_ASC, 'id' => SORT_ASC],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['=', 'sessia_vendor_code', $this->sessia_vendor_code])
            ->andFilterWhere(['like', 'sessia_title', $this->sessia_title])
            ->andFilterWhere(['=', 'category', $this->category])
            ->andFilterWhere(['=', 'collection', $this->collection])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'problems', $this->problems]);

        return $dataProvider;
    }

    public static function getCountries($model)
    {
        $html = '<h3 class="badge badge-warning">';
        $store_id = '';
        foreach ($model->getCountries($model->id) as $val) {
            if ($store_id !== $val['store_id']) {
                $html .= '</h3>';
                $html .= '<h3 class="badge badge-warning" style="display: block;text-align: left;">';
                $html .= $val['store_title'] . ' (' . $val['store_id'] . ')&nbsp;';
                $html .= '<span class="badge badge-info">';
                $html .= $val['product_title'] .' (' . $val['product_id'] . ')';
                $html .= '</span>';
            }
            $country = Country::findOne($val['country_id']);
            $html .= '<br><span class="badge badge-primary">' . $country->getLocalTitle() . ' (' . $country->id . ')</span>';
            $store_id = $val['store_id'];
        }
        $html .= '</h3>';

        return '
        <button
            class="btn btn-dark btn-sm mb-3"
            type="button" 
            data-toggle="collapse"
            data-target="#country-' . $model->id . '"
            aria-expanded="false"
            aria-controls="country-' . $model->id . '">' . Yii::t('app', 'Информация') . '</button>
        <div class="collapse" id="country-' . $model->id . '">
            ' . $html . '
        </div>
        ';
    }

    public static function getCategoryList()
    {
        $list = Product::getCategoryList();
        $arr = [];
        foreach ($list as $val) {
            $arr[$val['url']] = $val['label'];
        }
        return $arr;
    }

    public static function getCategory($model)
    {
        $categoryList = Product::getCategoryList();
        foreach ($categoryList as $val) {
            if ($model->category === $val['url']) {
                return $val['label'];
            }
        }
    }

    public static function getCollectionList()
    {
        $categoryList = Product::getCategoriesFilter();
        $arr = [];
        foreach ($categoryList as $category) {
            $option = [];
            $label = '';
            foreach ($category['items'] as $collection) {
                if ($label !== $collection['label']) {
                    $option[$collection['url']] = $collection['label'];
                }
                $label = $collection['label'];
            }
            $arr[$category['label']] = $option;
        }
        return $arr;
    }

    public static function getCollection($model)
    {
        $categoryList = Product::getCategoriesFilter();
        foreach ($categoryList as $category) {
            foreach ($category['items'] as $collection) {
                if ($model->collection === $collection['url']) {
                    return $collection['label'] . '<br><small>' . $category['label'] . '</small>';
                }
            }
        }
    }

    public static function getSexList($url = false)
    {
        $sexList = Product::getSexFilter();
        $arr = [];
        foreach ($sexList as $sexItem) {
            if ((!$url && !empty($sexItem['url'])) || $url) {
                $arr[$sexItem['url']] = $sexItem['label'];
            }
        }
        return $arr;
    }

    public static function getSexItem($model)
    {
        $sexList = Product::getSexFilter();
        foreach ($sexList as $sexItem) {
            if ($model->sex === $sexItem['url']) {
                return $sexItem['label'];
            }
        }
    }

    public static function getProblemList($url = false)
    {
        $problemList = Product::getProblemsFilter();
        $arr = [];
        foreach ($problemList as $problemItem) {
            if ((!$url && !empty($problemItem['url'])) || $url) {
                $arr[$problemItem['url']] = $problemItem['label'];
            }
        }
        return $arr;
    }

    public static function getProblems($model)
    {
        $problems = '';

        $problemList = Product::getProblemsFilter();
        foreach ($problemList as $problemItem) {
            if (preg_match("(" . $problemItem['url'] . ")", $model->problems)) {
                $problems .= $problemItem['label'] . ', ';
            }
        }

        return substr($problems, 0, -2);
    }

    public static function getLink($model)
    {
        $langTranslatorRepository = new LangTranslatorRepository();
        $langTranslator = $langTranslatorRepository->getByUserId(Yii::$app->user->id);
        $langDefault = Lang::getCurrent();

        return array_filter(['/admin/product/form', 'id' => $model->id, 'currencyIso' => 'RUB', 'lang' => $langTranslator ? $langTranslator->lang_id : '', 'langDefault' => $langDefault->id]);
    }
}
