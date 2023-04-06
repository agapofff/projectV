<?php

namespace app\controllers\store;

use app\forms\store\CartForm;
use app\repositories\OrderRepository;
use app\services\store\SessiaService;
use app\services\store\OrderService;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class OrderController extends Controller
{
    private $orderService;
    private $sessiaService;
    private $orderRepository;

    public function __construct(
        $id,
        $module,
        OrderService $orderService,
        SessiaService $sessiaService,
        OrderRepository $orderRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->orderService = $orderService;
        $this->sessiaService = $sessiaService;
        $this->orderRepository = $orderRepository;
    }

    ####################################################################################################################

    public function actionSaveCartData()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $form = new CartForm($order);
            if ($form->load(Yii::$app->request->post())) {
                if ($form->validate()) {
                    $this->orderService->updateCart($order, $form);
                    $this->orderService->recountPrices($order);
                    return true;
                }
                return Json::encode(ActiveForm::validate($form));
            }
        }
    }

    public function actionAddPromoCode()
    {
        if (Yii::$app->request->isAjax) {
            $this->orderService->addPromoCode(
                Yii::$app->params['order_id'],
                Yii::$app->request->post('code')
            );
            return true;
        }
    }

    public function actionRemovePromoCode()
    {
        if (Yii::$app->request->isAjax) {
            $this->orderService->addPromoCode(
                Yii::$app->params['order_id'],
                null
            );
            return true;
        }
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $form = new CartForm($order);
            if ($form->load(Yii::$app->request->post())) {
                $order = $this->orderService->updateCart($order, $form);

                $cookies = Yii::$app->request->cookies;
                $member_id = $cookies->has('member_id') ? $cookies->get('member_id') : '';

                $orderSessia = $this->sessiaService->createOrder(
                    Yii::$app->params['store_id'],
                    $order,
                    $order->client,
                    Yii::$app->params['lang_id'],
                    Url::to(['/store/default/thank-you-page', 'id' => $order->id, 'status' => 'success'], true),
                    Url::to(['/store/default/thank-you-page', 'id' => $order->id], true),
                    $member_id
                );
                $step = $this->orderService->createOrder($order, $orderSessia);

                if ($step->scenario === 'redirect') {
                    return '{"redirect":"' . $step->data . '"}';
                }

                return '{"error":' . $step->data . '}';
            }
        }
    }
}
