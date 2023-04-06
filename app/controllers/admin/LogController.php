<?php

namespace app\controllers\admin;

use app\forms\admin\LogForm;
use app\forms\admin\LogSearch;
use app\repositories\LogRepository;
use app\services\admin\LogService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class LogController extends Controller
{
    public $layout = 'admin';

    private $logService;
    private $logRepository;

    public function __construct(
        $id,
        $module,
        LogService $logService,
        LogRepository $logRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->logService = $logService;
        $this->logRepository = $logRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'change-status'],
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
        $logModel = new LogSearch();
        $dataProvider = $logModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'logModel' => $logModel,
        ]);
    }

    public function actionCreate()
    {
        $formLog = new LogForm();
        if ($formLog->load(Yii::$app->request->post()) && $formLog->validate()) {
            $this->logService->create(
                $formLog->type,
                $formLog->request,
                $formLog->response
            );
        }
    }

    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax) {
            $this->logService->changeStatus(
                Yii::$app->request->post('id'),
                Yii::$app->request->post('status')
            );
        }
    }
}
