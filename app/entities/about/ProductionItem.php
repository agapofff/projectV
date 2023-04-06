<?php

namespace app\entities\about;

use Yii;

/**
 * @property string id
 * @property string img
 * @property string title
 * @property string text
 */
class ProductionItem
{
    public $id;
    public $img;
    public $title;
    public $text;

    public function __construct($id) {
        $data = $this->getData()[$id];

        $this->id = $id;
        $this->img = $data['img'];
        $this->title = $data['title'];
        $this->text = $data['text'];
    }

    public function getPath() {
        return '@web/storage/products/production/';
    }

    public function getImg() {
        return $this->getPath() . '/' . $this->img . '?v=1';
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            1 => [
                'img' => 'img-1.jpg',
                'title' => Yii::t('app', '3 производственные площадки'),
                'text' => Yii::t('app', 'Помимо головного офиса, расположенного в Страсбурге, у Trading Point есть 3 производственные площадки:') . '<br>' .
                    Yii::t('app', '- для сухих форм – 4000 м2') . '<br>' .
                    Yii::t('app', '- для жидких форм – 3500 м2') . '<br>' .
                    Yii::t('app', '- для косметической продукции – 2300 м2'),
            ],
            2 => [
                'img' => 'img-2.jpg',
                'title' => Yii::t('app', 'Лучшие из лучших'),
                'text' => Yii::t('app', 'Trading Point на рынке уже 23 года. Но почти сразу после своего основания благодаря новейшим технологиям вошла в Топ-10 фармпроизводителей Франции.'),
            ],
            3 => [
                'img' => 'img-3.jpg',
                'title' => Yii::t('app', 'От исследования до доставки'),
                'text' => Yii::t('app', 'Trading Point не просто компания с «полным циклом разработки продукции».') . ' ' .
                    Yii::t('app', 'Формулы создают лучшие ученые мира, а лучшие специалисты занимаются производством, контролем качества и даже логистикой.'),
            ],
        ];
    }
}
