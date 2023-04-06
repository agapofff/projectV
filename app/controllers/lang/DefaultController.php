<?php

namespace app\controllers\lang;

use app\forms\lang\LangForm;
use app\forms\lang\LangSearch;
use app\repositories\LangRepository;
use app\repositories\StoreRepository;
use app\services\lang\LangService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends Controller
{
    public $layout = 'admin';

    private $langService;
    private $langRepository;
    private $storeRepository;

    public function __construct(
        $id,
        $module,
        LangService $langService,
        LangRepository $langRepository,
        StoreRepository $storeRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->langService = $langService;
        $this->langRepository = $langRepository;
        $this->storeRepository = $storeRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['import'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'form'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionImport()
    {
        $this->langService->import();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    ####################################################################################################

    public function actionIndex()
    {
        $searchModel = new LangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionForm($id)
    {
        $lang = $this->langRepository->get($id);

        $form = new LangForm($lang);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {

            if ($store = $this->storeRepository->get($form->store_id)){
                $this->langService->edit(
                    $lang->id,
                    $form->id,
                    $form->url,
                    $form->iso,
                    $form->name,
                    $store->id,
                    $store->currency_iso,
                    $form->active
                );
            }
            $this->redirect(['/lang/default/index']);
        }

        return $this->render('form', [
            'lang' => $lang,
            'model' => $form,
        ]);
    }
}
