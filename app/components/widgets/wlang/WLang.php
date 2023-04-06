<?php

namespace app\components\widgets\wlang;

use app\models\main\Lang;
use yii\bootstrap\Widget;

class WLang extends Widget
{
    public function run()
    {
        return $this->render('@app/components/widgets/wlang/views/wLang.php', [
            'current' => Lang::getCurrent(),
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->orderBy('sort_order')->all(),
        ]);
    }
}
