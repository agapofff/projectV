<?php

namespace app\widgets\asidelanguages;

use app\repositories\LangRepository;
use Yii;
use yii\bootstrap\Widget;

class AsideLanguages extends Widget
{
    public $only_icon = false;

    public function run()
    {
        $current_lang_id = Yii::$app->params['lang_id'];

        $langRepository = new LangRepository();
        $langCurrent = $langRepository->get($current_lang_id);

        if ($this->only_icon) {
            return $this->render('@app/widgets/asidelanguages/views/view_icon.php', [
                'langCurrent' => $langCurrent,
            ]);
        }

        $langs = $langRepository->getAllActiveExceptId($current_lang_id);
        if (Yii::$app->params['currency'] === 'UAH') {
            foreach ($langs as $key => $lang) {
                if (!preg_match("(uk|ru|en)", substr(mb_strtolower($lang->iso), 0, 2))) {
                    unset($langs[$key]);
                }
            }
        }

        return $this->render('@app/widgets/asidelanguages/views/view.php', [
            'langCurrent' => $langCurrent,
            'langs' => $langs,
        ]);
    }
}
