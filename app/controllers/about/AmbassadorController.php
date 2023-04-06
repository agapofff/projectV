<?php

namespace app\controllers\about;

use app\repositories\AmbassadorRepository;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;

class AmbassadorController extends Controller
{
    public $layout = 'front';

    private $ambassadorRepository;

    public function __construct(
        $id,
        $module,
        AmbassadorRepository $ambassadorRepository,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->ambassadorRepository = $ambassadorRepository;
    }

    ####################################################################################################################

    public function actionIndex()
    {
        if (Yii::$app->params['country_id'] !== 1) {
            throw new HttpException(404, Yii::t('admin', 'The requested page does not exist.'));
        }

        $ambassadors = $this->ambassadorRepository->getAll();

        return $this->render('index', [
            'ambassadors' => $ambassadors,
        ]);
    }

    public function actionView(int $id)
    {
        if (Yii::$app->params['country_id'] !== 1) {
            throw new HttpException(404, Yii::t('admin', 'The requested page does not exist.'));
        }

        $ambassador = $this->ambassadorRepository->get($id);
        $ambassadors = $this->ambassadorRepository->getAll();

        return $this->render('view', [
            'ambassador' => $ambassador,
            'ambassadors' => $ambassadors,
        ]);
    }
}
