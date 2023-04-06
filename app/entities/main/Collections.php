<?php

namespace app\entities\main;

use Exception;
use Yii;
use app\repositories\ProductRepository;

/**
 * @property string collection
 * @property string label
 * @property string title
 * @property string text
 * @property string list
 */
class Collections
{
    public $collection;
    public $label;
    public $title;
    public $text;
    public $list;

    public function __construct($collection) {
        $data = $this->getData()[$collection];

        $this->collection = $collection;
        $this->label = $data['label'];
        $this->title = $data['title'];
        $this->text = $data['text'];
        $this->list = $data['list'];
    }

    public function getProductCode($code)
    {
        return $code;
    }

    public function getProductId($key)
    {
        return $this->list[$key][0];
    }

    public function getProduct($id)
    {
        try {
            $product = new ProductRepository();
            return $product->get($id);
        } catch (Exception $err) {
            return false;
        }
    }

    public function getProductDesign($key)
    {
        return $this->list[$key][1];
    }

    public function getPath()
    {
        return '@web/storage/main/site/collections/' . $this->collection . '/';
    }

    public function getProductImg($key, $productImg = false)
    {
        if ($productImg) {
            return $productImg;
        }

        return $this->getPath() . $key . '.png?v=2';
    }

    public function getProductBg($key)
    {
        return $this->getPath() . $key . '.svg?v=1';
    }

    public function getLink()
    {
        if ($this->collection === 'classic-hit') {
            return ['/main/site/index'];
        } else {
            return ['/main/site/index', 'collection' => $this->collection];
        }
    }

    ####################################################################################################################

    public static function getMenu($collection)
    {
        $arr = [];
        foreach (self::getData() as $key => $val) {
            $model = new self($key);
            $arr['main']['items'][$key] = [
                    'label' => $val['label'],
                    'url' => $model->getLink(),
                    'active' => $collection === $key,
                ];
        }
        return $arr;
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            'classic-hit' => [
                'label' => 'Classic Hit Collection',
                'title' => Yii::t('admin', 'Classic Hit {br}Collection', ['br' => '<br>']),
                'text' => Yii::t('app', 'Биодобавки для ежедневной {br}комплексной защиты здоровья', ['br' => '<br>']),
                'list' => [
                    'A' => [25, 'van-gogh'],
                    'D' => [27, 'van-gogh'],
                    'M' => [31, 'van-gogh'],
                    'P' => [36, 'van-gogh'],
                    'N' => [34, 'van-gogh'],
                    'SV' => [38, 'van-gogh'],
                    'CH' => [26, 'van-gogh'],
                ],
                'bg' => 'classic-hit.svg',
            ],
            'direct-hit' => [
                'label' => 'Direct Hit Collection',
                'title' => Yii::t('admin', 'Direct Hit {br}Collection', ['br' => '<br>']),
                'text' => Yii::t('app', 'Биодобавки целевого действия {br}на&nbsp;конкретные органы и&nbsp;системы', ['br' => '<br>']),
                'list' => [
                    'OS' => [161, 'picasso'],
                    'DG' => [193, 'picasso'],
                    'DR' => [191, 'picasso'],
                    'BY' => [166, 'picasso'],
                    'BR' => [158, 'picasso'],
                    'ENT' => [159, 'picasso'],
                    'LV' => [157, 'picasso'],
                    //'CD' => [false, 'picasso'],
                    //'S' => [false, 'picasso'],
                ],
                'bg' => 'classic-hit.svg',
            ],
            'junior-hit' => [
                'label' => 'Junior Hit Collection',
                'title' => Yii::t('admin', 'Junior Hit {br}Collection', ['br' => '<br>']),
                'text' => Yii::t('app', 'Биодобавки для роста и&nbsp;здорового {br}развития детей и&nbsp;подростков', ['br' => '<br>']),
                'list' => [
                    'JN' => [29, 'van-gogh'],
                    'JNB' => [false, 'picasso'],
                ],
            ],
            'beauty-hit' => [
                'label' => 'Beauty Hit Collection',
                'title' => Yii::t('admin', 'Beauty Hit {br}Collection', ['br' => '<br>']),
                'text' => Yii::t('app', 'Натуральная косметика для красоты, {br}молодости и&nbsp;здоровья кожи', ['br' => '<br>']),
                'list' => [
                    //'GS' => [false, 'mondrian'],
                    'MS' => [221, false],
                    'MD' => [222, false],
                    'MH' => [223, false],
                    'MN' => [224, false],
                    'MY' => [225, false],
                    'M' => [33, false],
                ],
            ],
        ];
    }
}