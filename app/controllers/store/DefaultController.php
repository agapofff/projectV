<?php

namespace app\controllers\store;

use app\entities\store\Order;
use app\entities\store\Problem;
use app\forms\store\CartForm;
use app\forms\store\CatalogSearch;
use app\repositories\OrderRepository;
use app\repositories\ProductRepository;
use app\services\admin\SeoMetadataService;
use app\services\store\OrderService;
use app\services\store\SessiaService;
use app\widgets\datalayer\DataLayer;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public $layout = 'front';

    private $productRepository;
    private $seoMetadataService;
    private $sessiaService;
    private $orderService;
    private $orderRepository;

    public function __construct(
        $id,
        $module,
        ProductRepository $productRepository,
        SeoMetadataService $seoMetadataService,
        SessiaService $sessiaService,
        OrderService $orderService,
        OrderRepository $orderRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productRepository = $productRepository;
        $this->seoMetadataService = $seoMetadataService;
        $this->sessiaService = $sessiaService;
        $this->orderService = $orderService;
        $this->orderRepository = $orderRepository;
    }

    ####################################################################################################################

    public function actionReferral($member_id)
    {
        $this->orderService->setMemberId($member_id);

        return Yii::$app->response->redirect(['/main/site/index'], 301);
    }

    public function actionCatalog($category = '', $collection = '', $sex = '', $problem = '')
    {
        $searchModel = new CatalogSearch();
        $products = $searchModel->getProducts();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        $seoMedatada = $this->seoMetadataService->get([
            'title' => Yii::t('app', 'Каталог'),
            'breadcrumbs' => [
                [
                    'url' => ['/store/default/catalog'],
                    'label' => Yii::t('app', 'Каталог'),
                ],
            ],
            'robots' => $dataProvider->totalCount > 0,
        ]);

        $problemModel = new Problem();
        $problemArr = $problemModel->getItem($collection, $sex, $problem);

        return $this->render('catalog', [
            'products' => $products,
            'dataProvider' => $dataProvider,
            'category' => $category,
            'collection' => $collection,
            'sex' => $sex,
            'problem' => $problem,
            'seoMedatada' => $seoMedatada,
            'problemModel' => $problemModel,
            'problemArr' => $problemArr,
        ]);
    }

    public function actionProduct($id, $url = '', $from = '')
    {
        $product = $this->productRepository->get($id);

        if (!empty($from)) {
            return Yii::$app->response->redirect($product->getUrl(), 301);
        }
        if ($url !== $product->getTitleToUrl()) {
            return Yii::$app->response->redirect($product->getUrl(), 301);
        }

        $productCover = $product->coverByCurrencyIso;
        $productSessia = $product->sessiaByCurrencyIso;
        $productTranslate = $product->translateByLangId;

        $from = DataLayer::getList(Yii::$app->request->referrer);

        $seoMedatada = $this->seoMetadataService->get([
            'title' => str_replace("&nbsp;", " ", $productTranslate->title),
            'breadcrumbs' => [
                [
                    'url' => ['/store/default/catalog'],
                    'label' => Yii::t('app', 'Каталог'),
                ],
                [
                    'url' => $product->getUrl(),
                    'label' => $productTranslate->title,
                ],
            ],
            'product' => $product,
            'translate' => $productTranslate,
            'sessia' => $productSessia,
            'image' => $productCover->getUrl(),
        ]);

        return $this->render('product', [
            'product' => $product,
            'productCover' => $productCover,
            'productSessia' => $productSessia,
            'productTranslate' => $productTranslate,

            'from' => $from,
            'seoMedatada' => $seoMedatada,
        ]);
    }

    public function actionCountProducts()
    {
        if (Yii::$app->request->isAjax) {
            return $this->orderService->getCountProductsInCart(Yii::$app->params['order_id']);
        }
    }

    public function actionCart()
    {
        $order = $this->orderRepository->get(Yii::$app->params['order_id']);

        return $this->render('cart', [
            'order' => $order,
        ]);
    }

    public function actionCartAside()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            return $this->renderFile('@app/views/store/default/_cart-aside.php', [
                'order' => $order,
            ]);
        }
    }

    public function actionCartProduct()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            if ($orderProducts = $order->products) {
                return $this->renderFile('@app/views/store/default/_cart-product.php', [
                    'orderProducts' => $orderProducts,
                ]);
            }

            return false;
        }
    }

    public function actionCartDelivery()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $products = $this->orderService->getProducts($order);

            $delivery_type_list = $this->sessiaService->getDeliveryList(
                Yii::$app->params['country_id'],
                $order->client->city_id,
                Yii::$app->params['lang_id'],
                $products,
                Yii::$app->params['currency']
            );

            $delivery = $this->orderService->getDeliveryInfo($order, $delivery_type_list, $order->delivery_id);

            return $this->renderFile('@app/views/store/default/_cart-delivery.php', [
                'order' => $order,
                'model' => new CartForm($order),
                'delivery_type_list' => $delivery->type_list,
                'delivery_value' => $delivery->value,
            ]);
        }
    }

    public function actionCartPromoCode()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            return $this->renderFile('@app/views/store/default/_cart-promo-code.php', [
                'order' => $order,
                'model' => new CartForm($order),
            ]);
        }
    }

    public function actionCartPrice()
    {
        if (Yii::$app->request->isAjax) {
            $order = $this->orderRepository->get(Yii::$app->params['order_id']);

            $order = $this->orderService->recountPrices($order);

            return $this->renderFile('@app/views/store/default/_cart-price.php', [
                'order' => $order,
            ]);
        }
    }

    public function actionThankYouPage($id, $status = '')
    {
        if ($order = $this->orderService->getByClientId(Yii::$app->params['client_id'], $id)) {
            if ($orderResponse = $order->getResponse()) {
                if ($orderSessia = $this->sessiaService->getOrder($orderResponse->store->id ?? 0, $orderResponse->id ?? 0)) {
                    $paymentStatus = Order::getPaymentStatus($orderSessia->payment_service_system, $orderSessia->payment_status);
                    if ($order = $this->orderService->updateThankYouPage($order, $orderResponse, $orderSessia, $paymentStatus, $status)) {
                        return $this->render('thank-you-page', [
                            'order' => $order,
                            'orderSessia' => $orderSessia,
                        ]);
                    }
                }
            }
        }

        return $this->redirect(['/store/default/catalog']);
    }

    public function actionMail($id)
    {
        if ($order = $this->orderRepository->get($id)) {
            if ($orderResponse = $order->getResponse()) {
                if ($orderSessia = $this->sessiaService->getOrder($orderResponse->store->id ?? 0, $orderResponse->id ?? 0)) {
                    return $this->renderFile('@app/mail/store/cart/client-html.php', [
                        'order' => $order,
                        'orderSessia' => $orderSessia,
                        'orderResponse' => $orderResponse,
                        'paymentStatus' => Order::getPaymentStatus($orderSessia->payment_service_system, $orderSessia->payment_status),
                    ]);
                }
            }
        }
    }
}
