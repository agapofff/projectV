<?php

namespace app\entities\about;

use Yii;

/**
 * @property string title
 */
class Certificate
{
    public $title;

    public function __construct() {
        $data = $this->getData();

        $this->title = $data['title'];
    }

    ####################################################################################################################

    public static function getData()
    {
        return [
            'title' => Yii::t('app', 'Наши {br}сертификаты', ['br' => '<br>']),
        ];
    }
}
