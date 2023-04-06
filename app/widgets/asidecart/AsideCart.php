<?php

namespace app\widgets\asidecart;

use yii\bootstrap\Widget;

class AsideCart extends Widget
{
    public $only_icon = false;

    public function run()
    {
        if ($this->only_icon) {
            return $this->render('@app/widgets/asidecart/views/view_icon.php');
        }

        return $this->render('@app/widgets/asidecart/views/view.php');
    }
}
