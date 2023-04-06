<?php

namespace app\widgets\datalayer;

use yii\bootstrap\Widget;

class DataLayer extends Widget
{
    public $page = false;
    public $params = false;

    public function run()
    {
        /*if (isset($this->page)) {
            return $this->render('@app/widgets/datalayer/views/index.php', [
                'page' => $this->page,
                'params' => $this->params,
            ]);
        }*/
    }

    public static function getList($referrer)
    {
        if (preg_match("(" . $_SERVER['HTTP_HOST'] . ")", $referrer)) {
            if (empty($referrer) || (preg_match("(products|community|learning|contacts)", $referrer) && !preg_match("(store)", $referrer))) {
                return '';
            } elseif (preg_match("(cart)", $referrer)) {
                return '';
            } elseif (preg_match("(store)", $referrer)) {
                return 'store';
            }
            return 'main';
        }

        return '';
    }
}
