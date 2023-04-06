<?php

namespace app\controllers\admin;

use app\services\admin\ProductSessiaService;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class ProductSessiaController extends Controller
{
    public $layout = 'admin';

    private $productSessiaService;

    public function __construct(
        $id,
        $module,
        ProductSessiaService $productSessiaService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productSessiaService = $productSessiaService;
    }

    public function behaviors(): array
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
                        'actions' => ['import-product'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionImport($id)
    {
        if ($id === Yii::$app->params['secret_id']) {
            $this->productSessiaService->import();
        }

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * /admin/product-sessia/import-product/?store_type=mlm&product_id=305027
     */
    public function actionImportProduct(int $product_id)
    {
        $this->productSessiaService->importProduct($product_id);

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(['/admin/product/index/']);
        }
    }
}
