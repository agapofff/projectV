<?php

namespace app\controllers\admin;

use app\services\admin\CurrencyService;
use Yii;
use yii\web\Controller;

class CurrencyController extends Controller
{
    private $currencyService;

    public function __construct(
        $id,
        $module,
        CurrencyService $currencyService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->currencyService = $currencyService;
    }

    ####################################################################################################

    public function actionImport()
    {
        $this->currencyService->import();

        if (isset(Yii::$app->request->referrer)) {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
}
