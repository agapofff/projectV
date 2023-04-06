<?php

namespace app\controllers\admin;

use app\services\admin\ProductDocService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class ProductDocController extends Controller
{
    public $layout = 'admin';

    private $productDocService;

    public function __construct(
        $id,
        $module,
        ProductDocService $productDocService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productDocService = $productDocService;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['change-title'],
                        'allow' => true,
                        'roles' => ['translator'],
                    ],
                    [
                        'actions' => ['position', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionChangeTitle()
    {
        if (Yii::$app->request->isAjax) {
            $this->productDocService->changeTitle(
                Yii::$app->request->post('id'),
                Yii::$app->request->post('title')
            );
        }
    }

    public function actionPosition()
    {
        $items = $_POST['items'];
        if (Yii::$app->request->isAjax && isset($items) && is_array($items)) {
            $this->productDocService->updatePosition($items);
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $this->productDocService->remove(Yii::$app->request->post('id'));
        }
        return true;
    }
}
