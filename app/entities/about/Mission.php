<?php

namespace app\entities\about;

use Yii;
use yii\helpers\Url;

/**
 * @property string title
 * @property string subtitle
 * @property string text
 * @property array params
 * @property string video
 */
class Mission
{
    public $title;
    public $subtitle;
    public $text;
    public $params;
    public $video;

    public function __construct() {
        $data = $this->getData();

        $this->title = $data['title'];
        $this->subtitle = $data['subtitle'];
        $this->text = $data['text'];
        $this->params = $data['params'];
        $this->video = $data['video'];
    }

    ####################################################################################################################

    public static function getData()
    {
        $lang = Yii::$app->language === 'ru-RU' ? 'ru' : 'en';

        return [
            'title' => Yii::t('app', 'Миссия {br}компании', ['br' => '']),
            'subtitle' => Yii::t('app', 'Забота о красоте и здоровье людей'),
            'text' => Yii::t('app', 'Project V&nbsp;создает инновационные продукты, которые помогают миллионам людей день за&nbsp;днем укреплять здоровье и&nbsp;улучшать качество жизни. Используя в&nbsp;работе целебные силы природы, новейшие исследования и&nbsp;технологии, мы&nbsp;стремимся дать каждому человеку шанс быть здоровым и&nbsp;счастливым.') . '<br><br>' .
                Yii::t('app', 'Чтобы достичь этого, необходимо переключиться с&nbsp;питания на&nbsp;нейропитание, с&nbsp;нутритерапии&nbsp;&mdash; на&nbsp;нейронутритерапию. Тогда будет сделан важный шаг от&nbsp;здоровья к&nbsp;суперздоровью, и&nbsp;мы&nbsp;будем чаще задумываться не&nbsp;о&nbsp;количестве лет, а&nbsp;о&nbsp;их&nbsp;качестве.') . '<br><br>' .
                Yii::t('app', 'Мы&nbsp;работаем над тем, чтобы применение наших продуктов стало для людей полезной привычкой, которая изменит их&nbsp;жизнь и&nbsp;продлит активное долголетие.'),
            'params' => [
                2 => Yii::t('app', 'Миллиона {br}клиентов', ['br' => '<br>']),
                17 => Yii::t('app', 'Представлены {br}в странах', ['br' => '<br>']),
                48 => Yii::t('app', 'Уникальных {br}проектов', ['br' => '<br>']),
            ],
            'video' => '<video
                class="mission__video-iframe" controls="controls" loop=""><source src="' . Url::to('@web/storage/about/mission/fig.mp4?v=1') . '"
                type="video/mp4">Sorry, your browser doesn\'t support embedded videos.</video>',
        ];
    }
}
