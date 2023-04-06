<?php

namespace app\controllers\admin;

use app\forms\admin\SeoMetadataForm;
use app\forms\admin\SeoMetadataSearch;
use app\repositories\SeoMetadataRepository;
use app\services\admin\SeoMetadataService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class SeoMetadataController extends Controller
{
    public $layout = 'admin';

    private $seoMetadataService;
    private $seoMetadataRepository;

    public function __construct(
        $id,
        $module,
        SeoMetadataService $seoMetadataService,
        SeoMetadataRepository $seoMetadataRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->seoMetadataService = $seoMetadataService;
        $this->seoMetadataRepository = $seoMetadataRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
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

    public function actionIndex()
    {
        $searchModel = new SeoMetadataSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionCreate()
    {
        $this->seoMetadataService->create();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionUpdate($id)
    {
        if (Yii::$app->request->isAjax) {
            $seoMetadata = $this->seoMetadataRepository->get($id);

            $form = new SeoMetadataForm($seoMetadata);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $this->seoMetadataService->edit(
                    $seoMetadata->id,
                    $form->link,
                    $form->title,
                    $form->description,
                    $form->h1,
                    $form->text
                );
                return true;
            }
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $this->seoMetadataService->remove(Yii::$app->request->post('id'));
        }
        return true;
    }
}
