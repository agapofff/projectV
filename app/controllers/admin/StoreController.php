<?php

namespace app\controllers\admin;

use app\forms\admin\StoreForm;
use app\forms\admin\StoreSearch;
use app\repositories\StoreRepository;
use app\services\admin\StoreService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class StoreController extends Controller
{
    public $layout = 'admin';

    private $storeService;
    private $storeRepository;

    public function __construct(
        $id,
        $module,
        StoreService $storeService,
        StoreRepository $storeRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->storeService = $storeService;
        $this->storeRepository = $storeRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'form', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionAdd()
    {
        $form = $this->storeService->create();
        $this->redirect(['/admin/store/form', 'id' => $form->id]);
    }

    public function actionForm($id)
    {
        $store = $this->storeRepository->get($id);

        $form = new StoreForm($store);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->storeService->edit(
                $store->id,
                $form->id,
                $form->type,
                $form->title,
                $form->currency_iso
            );
            $this->redirect(['/admin/store/index']);
        }

        return $this->render('form', [
            'store' => $store,
            'model' => $form,
        ]);
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $this->storeService->remove(Yii::$app->request->post('id'));
        }
        return true;
    }
}
