<?php

namespace app\controllers\about;

use app\repositories\TeamRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class TeamController extends Controller
{
    public $layout = 'front';

    private $teamRepository;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        TeamRepository $teamRepository,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->teamRepository = $teamRepository;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################################

    public function actionIndex()
    {
        $menu = SiteService::getMenu();
        $title = SiteService::getTitlePage($menu, 'about', 'team');

        $this->seoMetadataService->get([
            'title' => $title,
            'breadcrumbs' => [
                $menu['about']['items']['team'],
            ],
        ]);

        return $this->render('index');
    }
}
