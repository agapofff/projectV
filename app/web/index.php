<?php

/*
// DATE Modifed
$date = new DateTime("2015-12-10"); // время последнего изменения страницы
$LastModified_unix = $date->format("U");
$LastModified = gmdate("D, d M Y H:i:s \G\M\T", $LastModified_unix);
$IfModifiedSince = false;
if (isset($_ENV['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']))
    $IfModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
if ($IfModifiedSince && $IfModifiedSince >= $LastModified_unix) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 304 Not Modified');
    exit;
}
header('Last-Modified: '. $LastModified);
*/

$domain = $_SERVER['SERVER_NAME'];
$request_uri = $_SERVER['REQUEST_URI'];

if (stristr($domain, ".dev.")) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    defined('YII_DEBUG') || define('YII_DEBUG', true);
    defined('YII_ENV') || define('YII_ENV', 'dev');
} else {
    //defined('YII_DEBUG') || define('YII_DEBUG', true);

    if ($request_uri == "/index.php" || $request_uri == "/index.htm") {
        header("Location: /", true, 301);
        exit();
    }

    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
        $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit;
    }

    if (stristr($request_uri, "//")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain . preg_replace('|([/]+)|s', '/', $request_uri);
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }

    if (stristr($request_uri, "catalog/collection-switzerland-cosmetics")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain . '/catalog/category-cosmeceuticals/collection-switzerland-cosmetics/';
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }

    if (stristr($request_uri, "catalog/product/300")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain . '/product/300-title/';
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }

    if (stristr($request_uri, "collection-dietary-supplements")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain;
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }

    if (stristr($request_uri, "/en/catalog/category-nutraceuticals/problem-excellent-vision/")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain . '/en/catalog/category-nutraceuticals/?problem=perfect-vision';
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }

    if (stristr($request_uri, "/en/catalog/category-nutraceuticals/collection-classic-hit/for-children/")) {
        $proc = 'http' . ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 's' : '') . '://';
        $location = $proc . $domain . '/en/catalog/category-nutraceuticals/collection-junior-hit/?sex=children';
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $location);
        exit();
    }
}

if (preg_match("(products/store)", $request_uri) && !preg_match("(cart|ready)", $request_uri)) {
    if (preg_match("([0-9]+-[a-z0-9-_]+)", $request_uri)) {
        header("Location: " . str_replace('products/store', 'store/product', $request_uri), true, 301);
        exit();
    } else {
        header("Location: " . str_replace('products/store', 'store', $request_uri), true, 301);
        exit();
    }
}

// регистрация загрузчика классов Composer
require(__DIR__ . '/../vendor/autoload.php');
// подключение файла класса Yii
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

// загрузка конфигурации приложения
$config = require(__DIR__ . '/../config/web.php');

// создание и конфигурация приложения, а также вызов метода для обработки входящего запроса
(new yii\web\Application($config))->run();
