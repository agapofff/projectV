<?php

namespace app\controllers\lang;

use app\forms\lang\LangTranslationSearch;
use app\repositories\LangRepository;
use app\repositories\LangTranslationRepository;
use app\repositories\LangTranslatorRepository;
use app\repositories\ProductRepository;
use app\services\lang\LangTranslationService;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\HttpException;

class LangTranslationController extends Controller
{
    public $layout = 'admin';

    private $langRepository;
    private $langTranslatorRepository;
    private $langTranslationRepository;
    private $langTranslationService;
    private $productRepository;

    public function __construct(
        $id,
        $module,
        LangRepository $langRepository,
        LangTranslatorRepository $langTranslatorRepository,
        LangTranslationRepository $langTranslationRepository,
        LangTranslationService $langTranslationService,
        ProductRepository $productRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->langRepository = $langRepository;
        $this->langTranslatorRepository = $langTranslatorRepository;
        $this->langTranslationRepository = $langTranslationRepository;
        $this->langTranslationService = $langTranslationService;
        $this->productRepository = $productRepository;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'form', 'update'],
                        'allow' => true,
                        'roles' => ['translator'],
                    ],
                    [
                        'actions' => ['delete', 'table', 'table2', 'products', 'messages'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    ####################################################################################################################

    public function actionIndex()
    {
        if (Yii::$app->user->can('admin')) {
            $languages = $this->langRepository->getAllActive();
        } else {
            $translator = $this->langTranslatorRepository->getByUserId(Yii::$app->user->id);
            $languages = $this->langRepository->getAllById($translator->lang_id);
        }

        $locale_from = 'ru-RU';

        return $this->render('index', [
            'languages' => $languages,
            'locale_from' => $locale_from,
        ]);
    }

    public function actionView(string $locale_from = 'ru-RU', string $locale_to, string $filter = null)
    {
        if (!$this->langTranslationService->checkAccess($locale_to, Yii::$app->user->id, Yii::$app->user->can('admin'))) {
            throw new HttpException(404, Yii::t('admin', 'The requested page does not exist.'));
        }

        $language_translations_search = new LangTranslationSearch();
        $language_translations = $language_translations_search->search($locale_from, $locale_to, $filter);

        $languages = $this->langRepository->getAll('name ASC');

        return $this->render('view', [
            'language_translations' => $language_translations,

            'locale_from' => $locale_from,
            'locale_to' => $locale_to,
            'filter' => $filter,

            'languages' => $languages,
        ]);
    }

    public function actionForm()
    {
        if (Yii::$app->request->isAjax) {

            $id = (int) Yii::$app->request->post('id');
            $locale = (string) Yii::$app->request->post('locale');
            $direction = (string) Yii::$app->request->post('direction');

            $language_translation = $this->langTranslationRepository->get($id);

            return $this->renderFile('@app/views/lang/lang-translation/_form.php', [
                'language_translation' => $language_translation,
                'locale' => $locale,
                'direction' => $direction,
            ]);
        }
    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {

            $id = (int) Yii::$app->request->post('id');
            $locale = (string) Yii::$app->request->post('locale');
            $message = (string) Yii::$app->request->post('message');
            $direction = (string) Yii::$app->request->post('direction');

            $language_translation = $this->langTranslationService->update(
                $id,
                $locale,
                $message
            );

            return $this->renderFile('@app/views/lang/lang-translation/_message.php', [
                'language_translation' => $language_translation,
                'locale' => $locale,
                'direction' => $direction,
            ]);
        }
    }

    public function actionDelete()
    {
        if (Yii::$app->request->isAjax) {
            $id = (int) Yii::$app->request->post('id');
            $this->langTranslationService->delete($id);
            return true;
        }
    }

    ####################################################################################################################

    /**
     * /en/lang/lang-translation/table2/?category=app
     * 2 - en
     * 6 - de
     * 7 - vi
     * 16 - it
     * 99 - uk
     */
    public function actionTable2($category = 'app')
    {
        $lang_ru = $this->langRepository->get(1);
        $lang_en = $this->langRepository->get(2);
        $lang_de = $this->langRepository->get(6);
        $lang_vi = $this->langRepository->get(7);
        $lang_it = $this->langRepository->get(16);
        $lang_uk = $this->langRepository->get(99);

        $messages = $this->langTranslationService->messagesOnline($category);
        $translations_en = include(Url::to('@webroot/../messages/' . $lang_en->iso . '/' . $category . '.php'));
        $translations_de = include(Url::to('@webroot/../messages/' . $lang_de->iso . '/' . $category . '.php'));
        $translations_vi = include(Url::to('@webroot/../messages/' . $lang_vi->iso . '/' . $category . '.php'));
        $translations_it = include(Url::to('@webroot/../messages/' . $lang_it->iso . '/' . $category . '.php'));
        $translations_uk = include(Url::to('@webroot/../messages/' . $lang_uk->iso . '/' . $category . '.php'));

        return $this->renderFile('@app/views/lang/lang-translation/table2.php', [
            'category' => $category,
            'lang_ru' => $lang_ru,
            'lang_en' => $lang_en,
            'lang_de' => $lang_de,
            'lang_vi' => $lang_vi,
            'lang_it' => $lang_it,
            'lang_uk' => $lang_uk,
            'messages' => $messages,
            'translations_en' => $translations_en,
            'translations_de' => $translations_de,
            'translations_vi' => $translations_vi,
            'translations_it' => $translations_it,
            'translations_uk' => $translations_uk,
        ]);
    }

    public function actionTable($lang = 2)
    {
        $langDefault = $this->langRepository->get(1);
        $lang = $this->langRepository->get($lang);

        $translations = $this->langTranslationRepository->getAll();

        return $this->renderFile('@app/views/lang/lang-translation/table.php', [
            'lang' => $lang,
            'langDefault' => $langDefault,
            'translations' => $translations,
        ]);
    }

    public function actionProducts($lang = 2)
    {
        $langDefault = $this->langRepository->get(1);
        $lang = $this->langRepository->get($lang);

        Yii::$app->params['lang_id'] = $langDefault->id;
        $productsDefault = $this->productRepository->getAllActive();

        return $this->renderFile('@app/views/lang/lang-translation/products.php', [
            'langDefault' => $langDefault,
            'lang' => $lang,
            'productsDefault' => $productsDefault,
        ]);
    }

    public function actionMessages()
    {
        $this->langTranslationService->messages();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
