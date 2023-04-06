<?php

namespace app\controllers\auth;

use app\forms\auth\SignupForm;
use app\repositories\ContestRepository;
use app\services\auth\SignupService;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class SignupController extends Controller
{
    public $layout = 'front-light';

    private $signupService;
    private $contestRepository;

    public function __construct(
        $id,
        $module,
        SignupService $signupService,
        ContestRepository $contestRepository,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->signupService = $signupService;
        $this->contestRepository = $contestRepository;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['request', 'confirm'],
                'rules' => [
                    [
                        'actions' => ['request'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionRequest()
    {
        $contest = $this->contestRepository->getLast();

        $form = new SignupForm();
        $form->date_of_birth = date('Y-m-d', $contest->getMinDateBirthday());
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->signupService->create($form->name, $form->date_of_birth, $form->username);

                // Перенаправляем на редактирование в личный кабинет
                return $this->redirect(['/user/participant/edit']);

            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('request', [
            'contest' => $contest,
            'model' => $form,
        ]);
    }
}
