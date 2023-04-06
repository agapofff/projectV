<?php

namespace app\controllers\admin;

use app\services\admin\ProductImgService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class ProductImgController extends Controller
{
    public $layout = 'admin';

    private $productImgService;

    public function __construct(
        $id,
        $module,
        ProductImgService $productImgService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productImgService = $productImgService;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['position', 'iso', 'delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionPosition()
    {
        $items = $_POST['items'];
        if (Yii::$app->request->isAjax && isset($items) && is_array($items)) {
            $this->productImgService->updatePosition($items);
        }
    }

    public function actionIso()
    {
        if (Yii::$app->request->isAjax) {
            $this->productImgService->updateIso(
                Yii::$app->request->post('id'),
                Yii::$app->request->post('iso')
            );
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $this->productImgService->remove(Yii::$app->request->post('id'));
        }
        return true;
    }
}
