<?php

namespace app\controllers\admin;

use app\forms\admin\LangInCountryForm;
use app\forms\admin\CountryForm;
use app\forms\admin\CountrySearch;
use app\repositories\CountryRepository;
use app\repositories\LangRepository;
use app\services\admin\CountryService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class CountryController extends Controller
{
    public $layout = 'admin';

    private $countryService;
    private $countryRepository;
    private $langRepository;

    public function __construct(
        $id,
        $module,
        CountryService $countryService,
        CountryRepository $countryRepository,
        LangRepository $langRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->countryService = $countryService;
        $this->countryRepository = $countryRepository;
        $this->langRepository = $langRepository;
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
                        'actions' => ['index', 'form'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################################

    public function actionImport()
    {
        $this->countryService->import();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    ####################################################################################################################

    public function actionIndex()
    {
        $searchModel = new CountrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionForm($id)
    {
        $langs = $this->langRepository->getAll();
        $formLangInCountry = new LangInCountryForm();

        $country = $this->countryRepository->get($id);

        $formCountry = new CountryForm($country);
        if ($formCountry->load(Yii::$app->request->post()) && $formCountry->validate()) {
            $this->countryService->edit(
                $country->id,
                $formCountry->domain,
                $formCountry->title,
                $formCountry->iso,
                $formCountry->lang_id,
                $formCountry->store_id,
                $formCountry->phone_code,
                $formCountry->phone_mask,
                $formCountry->post_code
            );
            $this->redirect(['/admin/country/index']);
        }

        return $this->render('form', [
            'langs' => $langs,
            'formLangInCountry' => $formLangInCountry,
            'country' => $country,
            'formCountry' => $formCountry,
        ]);
    }
}
