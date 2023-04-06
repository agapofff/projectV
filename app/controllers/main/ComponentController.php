<?php

namespace app\controllers\main;

use app\entities\main\Component;
use app\repositories\ProductRepository;
use Yii;
use yii\web\Controller;

class ComponentController extends Controller
{
    public $layout = 'front';

    private $productRepository;

    public function __construct(
        $id,
        $module,
        ProductRepository $productRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productRepository = $productRepository;
    }

    public function actionIndex(int $id)
    {
        $model = Component::getData()[$id];
        $product = $this->productRepository->get($model->product->id);

        return $this->render('index', [
            'url' => Component::getDir($id),
            'model' => $model,
            'product' => $product,
        ]);
    }

    public function actionView(int $id, string $url)
    {
        $model = Component::getData()[$id];
        $product = $model->product
            ? $this->productRepository->get($model->product->id)
            : false;

        if ($url !== $model->url) {
            return Yii::$app->response->redirect(['/main/component/view', 'id' => $id, 'url' => $model->url], 301);
        }

        return $this->render('view', [
            'url' => Component::getDir($id),
            'id' => $id,
            'model' => $model,
            'product' => $product,
        ]);
    }
}
