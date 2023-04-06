<?php

namespace app\controllers\store;

use app\repositories\OrderRepository;
use app\services\store\OrderProductService;
use app\services\store\OrderService;
use Yii;
use yii\web\Controller;

class OrderProductController extends Controller
{
    private $orderRepository;
    private $orderProductService;
    private $orderService;

    public function __construct(
        $id,
        $module,
        OrderRepository $orderRepository,
        OrderProductService $orderProductService,
        OrderService $orderService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->orderRepository = $orderRepository;
        $this->orderProductService = $orderProductService;
        $this->orderService = $orderService;
    }

    ####################################################################################################################

    public function actionPlus()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $quantity = $this->orderProductService->plus(
                $order,
                Yii::$app->request->post('product_id')
            );

            $this->orderService->recountPrices($order);
            $this->orderService->editDelivery($order, null, null, 0);

            return $quantity;
        }
    }

    public function actionMinus()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $quantity = $this->orderProductService->minus(
                $order,
                Yii::$app->request->post('product_id')
            );

            $this->orderService->recountPrices($order);
            $this->orderService->editDelivery($order, null, null, 0);

            return $quantity;
        }
    }

    public function actionChangeValue()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $quantity = $this->orderProductService->changeValue(
                $order,
                Yii::$app->request->post('product_id'),
                (int) Yii::$app->request->post('value')
            );

            $this->orderService->recountPrices($order);
            $this->orderService->editDelivery($order, null, null, 0);

            return $quantity;
        }
    }

    public function actionRemove()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $quantity = $this->orderProductService->remove(
                $order,
                Yii::$app->request->post('product_id')
            );

            $this->orderService->recountPrices($order);
            $this->orderService->editDelivery($order, null, null, 0);

            return $quantity;
        }
    }
}
