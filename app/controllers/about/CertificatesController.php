<?php

namespace app\controllers\about;

use app\repositories\CertificateRepository;
use app\repositories\CertificateItemRepository;
use app\services\admin\SeoMetadataService;
use app\services\main\SiteService;
use Yii;
use yii\web\Controller;

class CertificatesController extends Controller
{
    public $layout = 'front';

    private $certificateRepository;
    private $certificateItemRepository;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        CertificateRepository $certificateRepository,
        CertificateItemRepository $certificateItemRepository,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->certificateRepository = $certificateRepository;
        $this->certificateItemRepository = $certificateItemRepository;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################

    public function actionIndex()
    {
        $request_uri = $_SERVER['REQUEST_URI'];
        if (preg_match("(products)", $request_uri)) {
            return Yii::$app->response->redirect(['/about/certificates/index'], 301);
        }
        
        $model = $this->certificateRepository->get();
        $list = $this->certificateItemRepository->getAll();
    
        $menu = SiteService::getMenu();
        $title = SiteService::getTitlePage($menu, 'about', 'certificates');

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $title,
            'h1' => $model->title,
            'breadcrumbs' => [
                $menu['about']['items']['certificates'],
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
