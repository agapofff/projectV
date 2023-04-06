<?php

namespace app\components;

use app\repositories\SeoRedirectRepository;

class RedirectBootstrap
{
    /**
     * CountryService->change()     domain / placement
     * LangUrlManager->createUrl()  domain
     * widget countriesaside view   placement
     */
    public function __construct()
    {
        $domain = $_SERVER['SERVER_NAME'];
        $request_uri = $_SERVER['REQUEST_URI'];

        $seoRedirectRepository = new SeoRedirectRepository();
        $seoRedirect = $seoRedirectRepository->getByFrom($request_uri);
        if ($seoRedirect) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $this->getProtocol() . '://' . $domain. $seoRedirect->url_to);
            exit();
        }
    }

    public static function getProtocol()
    {
        return isset($_SERVER['HTTPS']) ? 'https' : 'http';
    }
}
