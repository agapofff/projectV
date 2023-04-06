<?php

namespace app\controllers\admin;

use app\services\admin\SeoService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SeoController extends Controller
{
    public $layout = 'admin';

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

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['sitemap', 'create-site-map'],
                        'allow' => true,
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    /**
     * https://www.sitemaps.org/ru/protocol.html
     * https://projectvint.ru/admin/seo/create-site-map/?id=1qE6aL45uQ9W
     */
    public function actionCreateSiteMap($id)
    {
        if ($id === Yii::$app->params['secret_id']) {
            $this->seoService->createSiteMap();
        }
    }
}
