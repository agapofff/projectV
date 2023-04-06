<?php

namespace app\controllers\contacts;

use app\forms\contacts\CallForm;
use app\forms\contacts\WriteForm;
use app\repositories\ContactRepository;
use app\services\admin\CountryService;
use app\services\admin\SeoMetadataService;
use app\services\contacts\ContactService;
use app\services\main\SiteService;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class ContactsController extends Controller
{
    public $layout = 'front';

    private $contactRepository;
    private $contactService;
    private $seoMetadataService;

    public function __construct(
        $id,
        $module,
        ContactRepository $contactRepository,
        ContactService $contactService,
        SeoMetadataService $seoMetadataService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->contactRepository = $contactRepository;
        $this->contactService = $contactService;
        $this->seoMetadataService = $seoMetadataService;
    }

    ####################################################################################################

    public function actionIndex($alias = '')
    {
        if (empty($alias)) {
            $contact = $this->contactRepository->getByCountryId(Yii::$app->params['country_id']);
            return $this->redirect(['/contacts/contacts/index', 'alias' => $contact->alias], 301);
        }

        $model = $this->contactRepository->getByUrl($alias);
        if (empty($model->alias)) {
            $contact = $this->contactRepository->getByCountryId(Yii::$app->params['country_id']);
            return $this->redirect(['/contacts/contacts/index', 'alias' => $contact->alias], 301);
        }

        $list = $this->contactRepository->getAll();
        $prev = $this->contactRepository->getPrev($alias);
        $next = $this->contactRepository->getNext($alias);

        $menu = SiteService::getMenu();
        unset($menu['contacts']['items']['sitemap']);
        $title = SiteService::getTitlePage($menu, 'contacts', 'contacts');

        $writeForm = new WriteForm();
        $callForm = new CallForm();
        $country = CountryService::getCountryById(Yii::$app->params['country_id']);

        $seoMedatada = $this->seoMetadataService->get([
            'title' => $title,
            'h1' => !empty($model->city) && empty($model->title) ? $model->city : $model->title,
            'breadcrumbs' => [
                [
                    'url' => $model->getLink(),
                    'label' => Yii::t('admin', '{title}: {text}', [
                        'title' => $title,
                        'text' => $model->city,
                    ]),
                ],
            ],
            'organization' => $alias === 'pr' ? false : $model,
        ]);

        return $this->render('index', [
            'alias' => $alias,
            'list' => $list,
            'model' => $model,
            'prev' => $prev,
            'next' => $next,
            'menu' => $menu,
            'title' => $title,
            'writeForm' => $writeForm,
            'callForm' => $callForm,
            'country' => $country,
            'seoMedatada' => $seoMedatada,
        ]);
    }

    public function actionWrite()
    {
        if (Yii::$app->request->isAjax) {
            $form = new WriteForm();
            if ($form->load(Yii::$app->request->post())) {
                if ($form->validate()) {
                    $this->contactService->sendMailWrite(
                        $form->name,
                        $form->email,
                        $form->text
                    );
                    return Json::encode([
                        'status' => 'success',
                        'html' => $this->renderFile('@app/views/contacts/contacts/_form-ready.php'),
                    ]);
                } else {
                    return Json::encode(ActiveForm::validate($form));
                }
            }
        }
    }

    public function actionCall()
    {
        if (Yii::$app->request->isAjax) {
            $form = new CallForm();
            if ($form->load(Yii::$app->request->post())) {
                if($form->validate()) {
                    $this->contactService->sendMailCall(
                        $form->name,
                        $form->phone
                    );
                    return Json::encode([
                        'status' => 'success',
                        'html' => $this->renderFile('@app/views/contacts/contacts/_form-ready.php'),
                    ]);
                } else {
                    return Json::encode(ActiveForm::validate($form));
                }
            }
        }
    }
}
