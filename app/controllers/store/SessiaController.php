<?php

namespace app\controllers\store;

use app\services\store\SessiaService;
use Yii;
use yii\web\Controller;

class SessiaController extends Controller
{
    private $sessiaService;

    public function __construct(
        $id,
        $module,
        SessiaService $sessiaService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->sessiaService = $sessiaService;
    }

    ####################################################################################################################

    public function actionGetCities()
    {
        if (Yii::$app->request->isAjax) {
            return json_encode($this->sessiaService->getCities(
                Yii::$app->params['country_id'],
                Yii::$app->params['lang_id'],
                10,
                Yii::$app->request->post('term')
            ));
        }
    }
}
