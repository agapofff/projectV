<?php

namespace app\assets;

use yii\web\AssetBundle;

class AppAssetAdmin extends AssetBundle
{
    public $css = [
        'front/libs/bootstrap/css/bootstrap-reboot.min.css',
        'front/libs/bootstrap/css/bootstrap.min.css',
        'front/libs/bootstrap/css/bootstrap-grid.min.css',
        'front/css/admin/main.min.css',
    ];
    public $js = [
        'front/libs/bootstrap/js/bootstrap.bundle.min.js',
        'front/libs/autosize.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
