<?php

namespace app\controllers\admin;

use app\entities\admin\ProductDoc;
use app\entities\admin\ProductImg;
use app\forms\admin\ProductDocForm;
use app\forms\admin\ProductImgForm;
use app\forms\admin\ProductSearch;
use app\forms\admin\ProductForm;
use app\forms\admin\ProductTranslateForm;
use app\repositories\CurrencyRepository;
use app\repositories\LangRepository;
use app\repositories\ProductDocRepository;
use app\repositories\ProductImgRepository;
use app\repositories\ProductRepository;
use app\repositories\ProductTranslateRepository;
use app\services\admin\ProductDocService;
use app\services\admin\ProductService;
use app\services\admin\ProductTranslateService;
use app\services\admin\ProductImgService;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\AccessControl;

class ProductController extends Controller
{
    public $layout = 'admin';

    private $productService;
    private $productRepository;
    private $productTranslateRepository;
    private $productImgRepository;
    private $productImgService;
    private $productDocRepository;
    private $productDocService;
    private $productTranslateService;
    private $currencyRepository;
    private $langRepository;

    public function __construct(
        $id,
        $module,
        ProductService $productService,
        ProductRepository $productRepository,
        ProductTranslateRepository $productTranslateRepository,
        ProductImgRepository $productImgRepository,
        ProductImgService $productImgService,
        ProductDocRepository $productDocRepository,
        ProductDocService $productDocService,
        ProductTranslateService $productTranslateService,
        CurrencyRepository $currencyRepository,
        LangRepository $langRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->productService = $productService;
        $this->productRepository = $productRepository;
        $this->productTranslateRepository = $productTranslateRepository;
        $this->productImgRepository = $productImgRepository;
        $this->productImgService = $productImgService;
        $this->productDocRepository = $productDocRepository;
        $this->productDocService = $productDocService;
        $this->productTranslateService = $productTranslateService;
        $this->currencyRepository = $currencyRepository;
        $this->langRepository = $langRepository;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['search'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'form'],
                        'allow' => true,
                        'roles' => ['translator'],
                    ],
                    [
                        'actions' => ['position', 'combine', 'add'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################

    public function actionSearch()
    {
        if (Yii::$app->request->isAjax) {
            $arr = $this->productService->search(Yii::$app->request->post('term'));

            return Json::encode([
                'html' => $this->renderFile('@app/widgets/asidesearch/views/_search-result.php', [
                    'arr' => $arr,
                ]),
            ]);
        }
    }

    ####################################################################################################

    public function actionIndex($sort = null)
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'sort' => $sort,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdd($sort = null)
    {
        return $this->render('add');
    }

    public function actionPosition()
    {
        $items = $_POST['items'];
        if (Yii::$app->request->isAjax && isset($items) && is_array($items)) {
            $this->productService->updatePosition($items);
        }
    }

    public function actionCombine($current_id, $id)
    {
        $this->productService->combine($current_id, $id);

        return $this->redirect(['/admin/product/form', 'id' => $id, 'currencyIso' => 'RUB', 'lang' => 1, 'langDefault' => 1]);
    }

    public function actionForm($id, $currencyIso = 'rub', $lang = 1, $langDefault = 1)
    {
        $product = $this->productRepository->get($id);

        $form = new ProductForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $this->productService->edit(
                $product,
                $form
            );
            if (isset(Yii::$app->request->referrer)) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        $productTranslateDefault = $this->productTranslateRepository->getByCurrencyProductLang($id, $langDefault);
        $productTranslate = $this->productTranslateRepository->getByCurrencyProductLang($id, $lang);
        if (!$productTranslate) {
            $productTranslate = $this->productTranslateService->create($id, $currencyIso, $lang);
        }
        $formProductTranslate = new ProductTranslateForm($productTranslate);
        if ($formProductTranslate->load(Yii::$app->request->post()) && $formProductTranslate->validate()) {
            $this->productTranslateService->edit(
                $productTranslate->id,
                $formProductTranslate->title,
                $formProductTranslate->description,
                $formProductTranslate->properties,
                $formProductTranslate->benefits,
                $formProductTranslate->video,
                $formProductTranslate->main_components,
                $formProductTranslate->composition,
                $formProductTranslate->recommendations,
                $formProductTranslate->dosage,
                $formProductTranslate->storage,
                $formProductTranslate->issue
            );
            if (isset(Yii::$app->request->referrer)) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        $productImg = new ProductImg();
        $productImg->product_id = $id;
        $productImg->currency_iso = $currencyIso;
        $formProductImg = new ProductImgForm($productImg);
        if ($formProductImg->load(Yii::$app->request->post()) && $formProductImg->validate()) {
            $this->productImgService->create($productImg, $formProductImg);
            if (isset(Yii::$app->request->referrer)) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        $productImgs = $this->productImgRepository->getAll($id);

        $productDoc = new ProductDoc();
        $productDoc->product_id = $id;
        $productDoc->lang_id = $lang;
        $formProductDoc = new ProductDocForm($productDoc);
        if ($formProductDoc->load(Yii::$app->request->post()) && $formProductDoc->validate()) {
            $this->productDocService->create($productDoc, $formProductDoc);
            if (isset(Yii::$app->request->referrer)) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        $productDocsDefault = $this->productDocRepository->getAll($id, $langDefault);
        $productDocs = $this->productDocRepository->getAll($id, $lang);

        $currencies = $this->currencyRepository->getAll();
        $lang = $this->langRepository->get($lang);
        $langDefault = $this->langRepository->get($langDefault);
        $langs = $this->langRepository->getAllForTranslators2();
        $langsAll = $langs;

        $products = $this->productRepository->getAll();

        return $this->render('form', [
            'product' => $product,
            'model' => $form,
            'currencies' => $currencies,
            'currencyIso' => $currencyIso,
            'langs' => $langs,
            'langsAll' => $langsAll,
            'lang' => $lang,
            'langDefault' => $langDefault,
            'productTranslateDefault' => $productTranslateDefault,
            'productTranslate' => $productTranslate,
            'modelProductTranslate' => $formProductTranslate,
            'formProductImg' => $formProductImg,
            'productImgs' => $productImgs,
            'productDocsDefault' => $productDocsDefault,
            'formProductDoc' => $formProductDoc,
            'productDocs' => $productDocs,
            'products' => $products,
        ]);
    }
}
