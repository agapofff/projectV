<?php

namespace app\entities\about;

use Yii;

/**
 * @property string id
 * @property string img
 * @property string title
 * @property string text
 * @property string date
 * @property string link
 */
class CertificateItem
{
    public $id;
    public $img;
    public $title;
    public $text;
    public $date;
    public $link;

    public function __construct($id) {
        $data = $this->getData()[$id];

        $this->id = $id;
        $this->img = $data['img'];
        $this->title = $data['title'];
        $this->text = $data['text'];
        $this->date = $data['date'];
        $this->link = $data['link'];
    }

    public function getPath() {
        return '@web/storage/about/certificates/';
    }

    public function getImg() {
        return $this->getPath() . '/' . $this->img . '?v=1';
    }

    public function getImgThumbnail() {
        return $this->getPath() . '/' . str_replace('.', '_thumbnail.', $this->img) . '?v=1';
    }

    public function getTitle() {
        return $this->title !== '' ? $this->title : false;
    }

    public function getDate() {
        return $this->date !== '' ? Yii::t('app', 'До {date}', ['date' => Yii::$app->formatter->asDate($this->date, 'medium')]) : false;
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            1 => [
                'img' => 'img-1.jpg',
                'title' => 'FR030371-1',
                'text' => Yii::t('app', 'Система менеджмента ISO 22000'),
                'date' => '2021-09-21',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            2 => [
                'img' => 'img-2.jpg',
                'title' => '2019-113',
                'text' => Yii::t('app', 'Система менеджмента GMP и пищевой безопасности HACCP'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            3 => [
                'img' => 'img-3.jpg',
                'title' => 'FQA 4001056/A',
                'text' => Yii::t('app', 'Система менеджмента ISO 9001:2008'),
                'date' => '2020-11-27',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            4 => [
                'img' => 'img-4.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии глютена в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            5 => [
                'img' => 'img-7.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии ГМО ингредиентов в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            6 => [
                'img' => 'img-5.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии ГМО ингредиентов в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            7 => [
                'img' => 'img-6.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии ГМО ингредиентов в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            8 => [
                'img' => 'img-8.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Завод сертифицирован согласно международным стандартам качества'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            9 => [
                'img' => 'img-9.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии глютена в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            10 => [
                'img' => 'img-10.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ о&nbsp;соответствии продуктов стандартам международной безопасности'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            11 => [
                'img' => 'img-11.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ о&nbsp;соответствии продуктов стандартам международной безопасности'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            12 => [
                'img' => 'img-12.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ о&nbsp;соответствии продуктов стандартам международной безопасности'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
            13 => [
                'img' => 'img-13.jpg',
                'title' => '',
                'text' => Yii::t('app', 'Документ об&nbsp;отсутствии глютена в&nbsp;продуктах'),
                'date' => '',
                'link' => 'http://www.tradingpoint.fr/en/regulations',
            ],
        ];
    }
}
