<?php

namespace app\widgets\asidecountries;

use app\repositories\CountryRepository;
use Yii;
use yii\bootstrap\Widget;

class AsideCountries extends Widget
{
    public $only_icon = false;

    public function run()
    {
        if (Yii::$app->params['currency'] === 'UAH') {
            return '';
        }

        $current_country_id = Yii::$app->params['country_id'];

        $countryRepository = new CountryRepository();
        $countryCurrent = $countryRepository->get($current_country_id);

        if ($this->only_icon) {
            return $this->render('@app/widgets/asidecountries/views/view_icon.php', [
                'countryCurrent' => $countryCurrent,
            ]);
        }

        $countries = $countryRepository->getAllActiveExceptCurrent($current_country_id);
        $c = [];
        foreach ($countries as $country) {
            $c[$country->getLocalTitle()] = $country;
        }
        ksort($c);

        return $this->render('@app/widgets/asidecountries/views/view.php', [
            'countryCurrent' => $countryCurrent,
            'countries' => $c,
        ]);
    }
}
