<?php

namespace app\components\lang;

use app\components\ParamsBootstrap;
use app\entities\admin\Country;
use Yii;
use yii\web\UrlManager;
use app\entities\lang\Lang;

class LangUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['lang_id'])) {
            // Если указан идентификатор языка, то делаем попытку найти язык в БД,
            // иначе работаем с языком по умолчанию
            $lang = Lang::get($params['lang_id']);
            if ($lang === null) {
                $lang = Lang::getDefault();
            }
            unset($params['lang_id']);
        } else {
            // Если не указан параметр языка, то работаем с текущим языком
            $lang = Lang::getCurrent();
        }

        if (isset($params['country_id'])) {
            $country_id = $params['country_id'];
            unset($params['country_id']);
        } else {
            $country_id = Yii::$app->params['country_id'];
        }
        $country = Country::findOne($country_id);
        /*$cache = Yii::$app->cache;
        $country = $cache->get('country-' . $country_id);
        if (!$country) {
            $country = Country::findOne($country_id);
            $cache->set('country-' . $country_id, $country, 60 * 60 * 24, [
                'updated_at' => $country->updated_at,
            ]);
        }*/

        if (isset($params['domain_current']) && isset($params['domain_new'])) {
            $domainCurrent = $params['domain_current'];
            $domainNew = $params['domain_new'];
            unset($params['domain_current']);
            unset($params['domain_new']);
        } else {
            $domainCurrent = '';
            $domainNew = '';
        }

        // Получаем сформированный URL (без префикса идентификатора языка)
        $url = parent::createUrl($params);
        $url = $country->lang_id === $lang->id ? $url : '/' . $lang->url . $url;
        $url = $domainCurrent !== $domainNew ? ParamsBootstrap::getUrl($domainNew, $url) : $url;

        return $url;
    }
}
