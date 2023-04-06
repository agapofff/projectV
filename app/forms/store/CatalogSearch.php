<?php

namespace app\forms\store;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\entities\admin\Product;

class CatalogSearch extends Model
{
    public $category;
    public $collection;
    public $sex;
    public $problem;

    public function rules()
    {
        return [
            [['category', 'collection', 'sex', 'problem'], 'string'],
            [['category', 'collection', 'sex', 'problem'], 'safe'],
        ];
    }

    public function getQuery()
    {
        return Product::find()->alias('p')
            ->innerJoinWith(['coverByCurrencyIso'])  // pi.*
            ->innerJoinWith(['translateByLangId'])  // pt.*
            ->where(['p.active' => 1])
            ->orderBy('p.position, p.id');
    }

    public function getProducts()
    {
        return $this->getQuery()->all();
    }

    public function search($params)
    {
        $params = ['CatalogSearch' => $params];

        $query = $this->getQuery();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 60,
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if (!empty($this->category)) {
            $sql = '';
            foreach (explode(',', $this->category) as $val) {
                $sql .= empty($sql) ? '' : ' OR ';
                $sql .= 'p.category LIKE "%' . $val . '%"';
            }
            $query->andWhere($sql);
        }

        if (!empty($this->collection)) {
            $sql = '';
            foreach (explode(',', $this->collection) as $val) {
                $sql .= empty($sql) ? '' : ' OR ';
                $sql .= 'p.collection LIKE "%' . $val . '%"';
            }
            $query->andWhere($sql);
        }

        if (!empty($this->sex)) {
            $sql = '';
            foreach (explode(',', $this->sex) as $val) {
                $sql .= empty($sql) ? '' : ' OR ';
                $sql .= 'p.sex LIKE "%' . $val . '%"';
            }
            $query->andWhere($sql);
        }

        if (!empty($this->problem)) {
            $sql = '';
            foreach (explode(',', $this->problem) as $val) {
                $sql .= empty($sql) ? '' : ' OR ';
                $sql .= 'p.problem LIKE "%' . $val . '%"';
            }
            $query->andWhere($sql);
        }

        return $dataProvider;
    }
}
