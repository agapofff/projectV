<?php

namespace app\controllers\lang;

use app\services\lang\LangTranslatorService;
use Yii;
use yii\web\Controller;

class LangTranslatorsController extends Controller
{
    public $layout = 'admin';

    private $langTranslatorService;

    public function __construct(
        $id,
        $module,
        LangTranslatorService $langTranslatorService,
        $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->langTranslatorService = $langTranslatorService;
    }

    ####################################################################################################

    public function actionCron($id)
    {
        if ($id === Yii::$app->params['secret_id']) {
            $this->langTranslatorService->information();
        }
        return true;
    }
}
