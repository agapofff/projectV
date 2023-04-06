<?php

namespace app\controllers\about;

use app\repositories\MissionRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use yii\web\Controller;

class MissionController extends Controller
{
    public $layout = 'front';

    private $missionRepository;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        MissionRepository $missionRepository,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->missionRepository = $missionRepository;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################################

    public function actionIndex()
    {
        $model = $this->missionRepository->get();

        $menu = SiteService::getMenu();
        $title = SiteService::getTitlePage($menu, 'about', 'mission');

        $this->seoMetadataService->get([
            'title' => $title,
            'h1' => $model->title,
            'breadcrumbs' => [
                $menu['about']['items']['mission'],
            ],
        ]);

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
