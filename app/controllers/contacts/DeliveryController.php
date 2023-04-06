<?php

namespace app\controllers\contacts;

use app\repositories\DeliveryRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use yii\web\Controller;

class DeliveryController extends Controller
{
    public $layout = 'front';

    private $deliveryRepository;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        DeliveryRepository $deliveryRepository,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->deliveryRepository = $deliveryRepository;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################

    public function actionIndex()
    {
        $model = $this->deliveryRepository->get();

        $menu = SiteService::getMenu();
        unset($menu['contacts']['items']['sitemap']);
        $title = SiteService::getTitlePage($menu, 'contacts', 'delivery');

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $title,
            'h1' => $model->payment_title,
            'breadcrumbs' => [
                $menu['contacts']['items']['delivery'],
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
            'menu' => $menu,
            'title' => $title,
            'seoMedatada' => $seoMedatada,
        ]);
    }
}
