<?php

namespace app\controllers\about;

use app\repositories\ProductionRepository;
use app\repositories\ProductionItemRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use yii\web\Controller;

class ProductionController extends Controller
{
    public $layout = 'front';

    private $productionRepository;
    private $productionItemRepository;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        ProductionRepository $productionRepository,
        ProductionItemRepository $productionItemRepository,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productionRepository = $productionRepository;
        $this->productionItemRepository = $productionItemRepository;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################

    public function actionIndex()
    {
        $model = $this->productionRepository->get();
        $list = $this->productionItemRepository->getAll();

        $menu = SiteService::getMenu();
        $title = SiteService::getTitlePage($menu, 'about', 'production');

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $title,
            'h1' => $model->title,
            'breadcrumbs' => [
                $menu['about']['items']['production'],
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
            'list' => $list,
            'title' => $title,
            'seoMedatada' => $seoMedatada,
        ]);
    }
}
