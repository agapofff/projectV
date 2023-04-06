<?php

namespace app\services\main;

use app\repositories\ProductRepository;
use app\services\mail\MailService;
use Yii;
use yii\web\Cookie;

class SiteService
{
    private $mailService;
    private $productRepository;

    public function __construct(
        MailService $mailService,
        ProductRepository $productRepository
    )
    {
        $this->mailService = $mailService;
        $this->productRepository = $productRepository;
    }

    public static function getMenu($currentUrl = '')
    {
        $currentUrl = !empty($currentUrl) ? $currentUrl : Yii::$app->request->url;

        return [
            'products' => [
                'label' => Yii::t('app', 'Каталог'),
                'url' => ['/store/default/catalog'],
                'options' => ['data-section' => 'products'],
                'active' => preg_match("(catalog)", $currentUrl),
                'items' => [
                    'cosmetics' => [
                        'label' => Yii::t('app', 'Нутрицевтики'),
                        'url' => ['/store/default/catalog', 'category' => 'nutraceuticals'],
                    ],
                    'dietary-supplements' => [
                        'label' => Yii::t('app', 'Космецевтика'),
                        'url' => ['/store/default/catalog', 'category' => 'cosmeceuticals'],
                    ],
                    'pentactive-neo' => [
                        'label' => Yii::t('app', 'Титановые браслеты'),
                        'url' => ['/store/default/catalog', 'category' => 'titanium-bracelets'],
                    ],
                ],
            ],
            'about' => [
                'label' => Yii::t('app', 'О нас'),
                'url' => ['/about/mission/index'],
                'options' => ['data-section' => 'about'],
                'active' => preg_match("(about)", $currentUrl),
                'items' => [
                    'mission' => [
                        'label' => Yii::t('app', 'Миссия'),
                        'url' => ['/about/mission/index'],
                        'active' => preg_match("(/about/mission)", $currentUrl),
                    ],
                    'ambassadors' => [
                        'label' => Yii::t('amba', 'Амбассадоры'),
                        'url' => ['/about/ambassador/index'],
                        'active' => preg_match("(/about/ambassador)", $currentUrl),
                        'visible' => Yii::$app->params['currency'] === 'RUB',
                    ],
                    'team' => [
                        'label' => Yii::t('app', 'Команда'),
                        'url' => ['/about/team/index'],
                        'active' => preg_match("(/about/team)", $currentUrl),
                        'visible' => Yii::$app->params['currency'] === 'EUR',
                    ],
                    /*'mass-media' => [
                        'label' => Yii::t('app', 'Пресса'),
                        'url' => ['/about/post/index', 'type' => 'mass-media'],
                        'active' => preg_match("(mass-media)", $currentUrl),
                        'visible' => Yii::$app->params['currency'] === 'RUB',
                    ],
                    'blog' => [
                        'label' => Yii::t('app', 'Блог'),
                        'url' => ['/about/post/index', 'type' => 'blog'],
                        'active' => preg_match("(blog)", $currentUrl),
                        'visible' => Yii::$app->params['currency'] === 'RUB',
                    ],*/
                    'production' => [
                        'label' => Yii::t('app', 'Производство'),
                        'url' => ['/about/production/index'],
                        'active' => preg_match("(/about/production)", $currentUrl),
                    ],
                    'certificates' => [
                        'label' => Yii::t('app', 'Сертификаты'),
                        'url' => ['/about/certificates/index'],
                        'active' => preg_match("(/about/certificates)", $currentUrl),
                    ],
                ],
            ],
            'contacts' => [
                'label' => Yii::t('app', 'Контакты'),
                'url' => ['/contacts/contacts/index'],
                'options' => ['data-section' => 'contacts'],
                'active' => preg_match("(contacts)", $currentUrl),
                'items' => [
                    'contacts' => [
                        'label' => Yii::t('app', 'Контакты'),
                        'url' => ['/contacts/contacts/index'],
                        'active' => preg_match("(/contacts/contacts)", $currentUrl),
                    ],
                    'delivery' => [
                        'label' => Yii::t('app', 'Доставка'),
                        'url' => ['/contacts/delivery/index'],
                        'active' => preg_match("(/contacts/delivery)", $currentUrl),
                    ],
                    'sitemap' => [
                        'label' => Yii::t('app', 'Карта сайта'),
                        'url' => ['/contacts/sitemap/index'],
                        'active' => preg_match("(/contacts/sitemap)", $currentUrl),
                    ],
                ],
            ],
        ];
    }

    public static function getMenuLabel($section)
    {
        return self::getMenu()[$section]['label'];
    }

    public static function getMenuLight()
    {
        $menu = [];
        foreach (self::getMenu() as $val) {
            unset($val['items']);
            $menu[] = $val;
        }
        return $menu;
    }

    public static function getTitlePage($menu, $section, $page)
    {
        return $menu[$section]['items'][$page]['label'];
    }

    public static function getMenuSection($menu, $section)
    {
        return $menu[$section]['items'];
    }

    public static function getPrevLinkMenu($menu, $current)
    {
        $keyCurrent = 0;
        $i = 0;
        foreach ($menu as $key => $val) {
            if ($key === $current) {
                $keyCurrent = $i;
                break;
            }
            $i++;
        }

        $menu = array_values($menu);

        if ($keyCurrent <= 0) {
            $prev = false;
        } else {
            $prev = $menu[$keyCurrent - 1]['url'];
        }

        return $prev;
    }

    public static function getNextLinkMenu($menu, $current)
    {
        $keyCurrent = 0;
        $i = 0;
        foreach ($menu as $key => $val) {
            if ($key === $current) {
                $keyCurrent = $i;
                break;
            }
            $i++;
        }

        $menu = array_values($menu);

        if ($keyCurrent >= count($menu) - 1) {
            $next = false;
        } else {
            $next = $menu[$keyCurrent + 1]['url'];
        }

        return $next;
    }

    public static function getSettingMenu()
    {
        return [
            'options' => [
                'id' => 'menu__list',
                'class' => 'menu__list',
                'classLink' => 'menu__link',
            ],
            'itemOptions' => [
                'class' => 'menu__item',
            ],
            'linkTemplate' => '<a href="{url}" class="menu__link">{label}</a>',
            'activeCssClass' => 'active',
            'encodeLabels' => false,
        ];
    }

    public static function makeVideo($link)
    {
        $link = preg_replace(
            '#((https|http):\/\/([a-zA-Z0-9]+\.|)youtube\.com\/.*v=([a-zA-Z0-9_-]+).*)#i',
            '<iframe width="100%" height="100%" class="parties-nav__video" src="https://www.youtube.com/embed/\\4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            $link
        );
        $link = preg_replace(
            '#((https|http):\/\/youtu\.be\/([a-zA-Z0-9_-]+).*)#i',
            '<iframe width="100%" height="100%" class="parties-nav__video" src="https://www.youtube.com/embed/\\3" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            $link
        );

        return $link;
    }

    public static function getCookies()
    {
        $cookies = Yii::$app->request->cookies;
        if ($cookies->has('cookies')) {
            return $cookies->get('cookies');
        }
        return '';
    }

    public function setCookies()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'cookies',
            'value' => 'OK',
        ]));
    }

    public function setOs()
    {
        $cookies = Yii::$app->response->cookies;
        $cookies->add(new Cookie([
            'name' => 'os',
            'value' => 'OK',
        ]));
    }
}
