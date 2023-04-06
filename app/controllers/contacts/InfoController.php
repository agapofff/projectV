<?php

namespace app\controllers\contacts;

use app\repositories\DeliveryRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use yii\web\Controller;

class InfoController extends Controller
{
    public $layout = 'front';

    public function actionIndex($url)
    {
        return $this->render($url);
    }
}
