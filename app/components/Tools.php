<?php

namespace app\components;

class Tools
{
    public static function isWebView()
    {
        $isWebView = false;

        if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)) :
            $isWebView = true;
        elseif (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) :
            $isWebView = true;
        endif;

        return $isWebView;
    }
}
