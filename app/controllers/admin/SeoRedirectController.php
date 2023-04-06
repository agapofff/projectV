<?php

namespace app\controllers\admin;

use app\forms\admin\SeoRedirectSearch;
use app\repositories\SeoRedirectRepository;
use app\services\admin\SeoRedirectService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class SeoRedirectController extends Controller
{
    public $layout = 'admin';

    private $seoRedirectService;
    private $seoRedirectRepository;

    public function __construct(
        $id,
        $module,
        SeoRedirectService $seoRedirectService,
        SeoRedirectRepository $seoRedirectRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->seoRedirectService = $seoRedirectService;
        $this->seoRedirectRepository = $seoRedirectRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['go'],
                        'allow' => true,
                        'roles' => ['seo'],
                    ],
                    [
                        'actions' => ['index', 'create', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['seo'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionGo($url_from)
    {
        $seoRedirect = $this->seoRedirectRepository->getByFrom($url_from);

        if ($seoRedirect) {
            return $this->redirect($seoRedirect->url_to);
        }

        throw new \RuntimeException('Url not find.');
    }

    ####################################################################################################

    public function actionIndex()
    {
        $searchModel = new SeoRedirectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $this->seoRedirectService->create();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $this->seoRedirectService->edit(
                Yii::$app->request->post('id'),
                Yii::$app->request->post('type'),
                Yii::$app->request->post('url_from'),
                Yii::$app->request->post('url_to')
            );
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $this->seoRedirectService->remove(Yii::$app->request->post('id'));
        }
        return true;
    }
}
