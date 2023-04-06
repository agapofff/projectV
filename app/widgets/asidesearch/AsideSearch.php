<?php

namespace app\widgets\asidesearch;

use yii\bootstrap\Widget;

class AsideSearch extends Widget
{
    public $only_icon = false;

    public function run()
    {
        if ($this->only_icon) {
            return $this->render('@app/widgets/asidesearch/views/view_icon.php');
        }

        return $this->render('@app/widgets/asidesearch/views/view.php');
    }
}
