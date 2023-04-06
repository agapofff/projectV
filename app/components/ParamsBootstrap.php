<?php

namespace app\components;

use app\repositories\CountryRepository;
use app\services\store\SessiaService;
use Yii;

class ParamsBootstrap
{
    /**
     * CountryService->change()     domain / placement
     * LangUrlManager->createUrl()  domain
     * widget countriesaside view   placement
     */
    public function __construct()
    {
        $domain = YII_ENV_DEV
            ? str_replace(".dev", "", $_SERVER['SERVER_NAME'])
            : $_SERVER['SERVER_NAME'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $currentUrl = $this->getUrl($domain, $request_uri);

        $countryRepository = new CountryRepository();
        $country = $countryRepository->getByDomain($domain);
        if (!$country) {
            $country = $this->getCountry();
        }

        if ($lang = $country->lang) {
            if ((preg_match("(/" . $lang->url . "/)", $request_uri) || $country->domain !== $domain)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . str_replace($domain, $country->domain,  str_replace("/" . $lang->url, "", $currentUrl)));
                exit();
            }
        }

        Yii::$app->params['country_id'] = $country->id;
        Yii::$app->params['lang_id'] = $country->lang_id;
        Yii::$app->params['currency'] = $country->currency_iso;
        Yii::$app->params['store_id'] = $country->store_id;
        Yii::$app->params['phone_code'] = str_replace('+', '', $country->phone_code);
        Yii::$app->params['post_code'] = $country->post_code;

        Yii::$app->params['os'] = empty($this->getCookieOs()) ? $this->getOs() : NULL;
    }

    ############################################################################

    public static function getUrl($domain, $request_uri = '')
    {
        $https = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        return $https . "://" . $domain . $request_uri;
    }

    public function getCountry()
    {
        $countryRepository = new CountryRepository();

        if (YII_ENV_DEV) {

            $country = $countryRepository->get(1020);  // Austria

        } else {

            $sessiaService = new SessiaService();
            if ($geodata = $sessiaService->getGeodataByIp($_SERVER['REMOTE_ADDR'])) {
                $country = $countryRepository->getByIdAndNotNullDomain($geodata->country->id);
            }

            if (!$country) {
                $country = $countryRepository->get(1020);  // Austria
            }
        }

        return $country;
    }

    public function getOs()
    {
        $oss = [
            'android' => 'Android',
            'ios' => 'iPhone',
        ];

        $os = NULL;
        foreach ($oss as $key => $val) {
            if (preg_match('#' . $val . '#i', $_SERVER['HTTP_USER_AGENT'])) {
                $os = $key;
                break;
            }
        }

        return $os;
    }

    public function getCookieOs()
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('os')) {
            return $cookies->get('os');
        }
        return '';
    }
}
