<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'front/libs/swiper/swiper-bundle.min.css',
        'front/libs/liMarquee/liMarquee.css',
        'front/libs/animate.css/animate.css',
        'front/libs/aos/aos.css',
        'front/libs/slickslider/slick.css',
        'front/libs/jquery-ui/jquery-ui.min.css',
        'front/css/main.min.css',
    ];
    public $js = [
        'front/libs/swiper/swiper-bundle.min.js',
        'front/libs/liMarquee/jquery.liMarquee.js',
        'front/libs/jquery.simplemarquee.js',
        'front/libs/animate.css/wow.min.js',
        'front/libs/aos/aos.js',
        'front/libs/slickslider/slick.js',
        'front/libs/jquery-ui/jquery-ui.min.js',
        'front/js/common.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
