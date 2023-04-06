<?php

namespace app\components;

use Yii;
use yii\web\Cookie;

class UtmBootstrap
{
    public function __construct()
    {
        $this->checkUtm();
    }

    public static function checkUtm()
    {
        $utm = '';
        $request_uri = $_SERVER['REQUEST_URI'];

        if (preg_match("(utm)", $request_uri)) {

            $arr = substr(stristr($request_uri, "?"), 1);

            foreach (explode('&', $arr) as $tmp) {
                $tmp2 = explode('=', $tmp);
                $key = $tmp2[0];
                unset ($tmp2[0]);
                if (preg_match("(utm)", $key)) {
                    $utm .= $key . '=' . implode('=', $tmp2) . '/';
                }
            }

            $cookies = Yii::$app->response->cookies;
            $cookies->add(new Cookie([
                'name' => 'utm',
                'value' => $utm,
            ]));
        } else {
            $cookies = Yii::$app->request->cookies;
            if ($cookies->has('utm')) {
                $utm = $cookies->get('utm');
            }
        }

        return $utm;
    }
}
