<?php

namespace app\controllers\contacts;

use app\services\admin\SeoService;
use yii\web\Controller;

class SitemapController extends Controller
{
    public $layout = 'front';

    private $seoService;

    public function __construct(
        $id,
        $module,
        SeoService $seoService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->seoService = $seoService;
    }

    ####################################################################################################

    public function actionIndex()
    {
        $urls = $this->seoService->getSitemap();

        return $this->render('index', [
            'urls' => $urls,
        ]);
    }
}
