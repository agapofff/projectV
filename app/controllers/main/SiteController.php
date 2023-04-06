<?php

namespace app\controllers\main;

use app\forms\store\StoreSearch;
use app\repositories\ProductRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = 'front';

    private $seoMetadataService;
    private $productRepository;
    private $siteService;

    public function __construct(
        $id,
        $module,
        SeoMetadataService $seoMetadataService,
        ProductRepository $productRepository,
        SiteService $siteService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->seoMetadataService = $seoMetadataService;
        $this->productRepository = $productRepository;
        $this->siteService = $siteService;
    }

    ####################################################################################################################

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '/main/site/error',
            ],
        ];
    }

    ####################################################################################################################

    public function actionVideoVHit()
    {
        switch (Yii::$app->params['currency']) {
            case 'RUB':
                $lang = 'ru';
                break;
            case 'VND':
                $lang = 'vi';
                break;
            default:
                $lang = 'en';
        }

        return $lang;
    }

    ####################################################################################################################

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($category)
    {
        $seoMedatada = $this->seoMetadataService->get();

        $products = $this->productRepository->getAllByCategory($category);

        return $this->render('view', [
            'seoMedatada' => $seoMedatada,
            'category' => $category,
            'products' => $products,
        ]);
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionTermsAndConditions()
    {
        return $this->render('terms-and-conditions');
    }

    public function actionSetCookies()
    {
        if (Yii::$app->request->isAjax) {
            $this->siteService->setCookies();
        }
    }

    public function actionSetOs()
    {
        if (Yii::$app->request->isAjax) {
            $this->siteService->setOs();
        }
    }
}
