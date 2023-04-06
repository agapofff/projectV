<?php

namespace app\entities\about;

use Yii;

/**
 * @property int id
 * @property string img
 * @property string title
 * @property string subtitle
 * @property string text
 */
class Team
{
    public $id;
    public $img;
    public $title;
    public $subtitle;
    public $text;

    public function __construct($id) {
        $data = $this->getData()[$id];

        $this->id = $id;
        $this->img = $data['img'];
        $this->title = $data['title'];
        $this->subtitle = $data['subtitle'];
        $this->text = $data['text'];
    }

    public function getPath() {
        return '@web/storage/about/team/';
    }

    public function getImgThumbnail() {
        return $this->getPath() . str_replace('.', '_thumbnail.', $this->img) . '?v=3';
    }

    public function getImg() {
        return $this->getPath() . $this->img . '?v=3';
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            17 => [
                'img' => 'screen-17.png',
                'title' => Yii::t('app', 'Андрей {br}Елисеев', ['br' => '']),
                'subtitle' => Yii::t('app', 'Руководитель контент департамента'),
                'text' => Yii::t('admin', ''),
            ],
            19 => [
                'img' => 'screen-19.png',
                'title' => Yii::t('app', 'Николай {br}Шугайлов', ['br' => '']),
                'subtitle' => Yii::t('app', 'Креативный директор'),
                'text' => Yii::t('admin', ''),
            ],
            1 => [
                'img' => 'screen-0.png',
                'title' => Yii::t('app', 'Нарек {br}Сираканян', ['br' => '']),
                'subtitle' => Yii::t('app', 'Президент Freedom Group'),
                'text' => Yii::t('app', 'Молодой и энергичный лидер с 10-летним опытом работы в банковской и корпоративной сферах.') . ' ' .
                    Yii::t('app', 'Был лучшим студентом в крупнейшем канадском университете McGill.') . ' ' .
                    Yii::t('app', 'В 23 года стал самым молодым топ-менеджером Росатома.') . ' ' .
                    Yii::t('app', 'В 2017 году основал Freedom Group. Сейчас активы компании — $2,5 млрд.'),
            ],
            2 => [
                'img' => 'screen-1.png',
                'title' => Yii::t('app', 'Анна {br}Саруханян', ['br' => '']),
                'subtitle' => Yii::t('app', 'Главный советник президента'),
                'text' => Yii::t('app', 'Успех бизнеса зависит от команды.') . ' ' .
                    Yii::t('app', 'Я не просто ищу крутых профессионалов, а формирую коллектив, который способен реализовать любые задачи.'),
            ],
            13 => [
                'img' => 'screen-12.png',
                'title' => Yii::t('app', 'Валерия {br}Коломиец', ['br' => '']),
                'subtitle' => Yii::t('app', 'R&D Директор'),
                'text' => Yii::t('app', 'Возможности воплотить в продуктах передовые научные разработки для улучшения качества жизни современного человека, поддержать его здоровье и активность в реализации самых смелых своих идей – всё это несет мне радость и вдохновение в работе.'),
            ],
        ];
    }
}
