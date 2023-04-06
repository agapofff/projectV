<?php

namespace app\services\admin;

use app\entities\admin\ProductSessia;
use app\repositories\CollectionsRepository;
use app\repositories\PostRepository;
use app\repositories\ProductRepository;
use app\services\main\SiteService;
use yii\helpers\FileHelper;
use yii\helpers\Url;

class SeoService
{
    private $collectionsRepository;
    private $productRepository;
    private $postRepository;

    public function __construct(
        CollectionsRepository $collectionsRepository,
        ProductRepository $productRepository,
        PostRepository $postRepository
    )
    {
        $this->collectionsRepository = $collectionsRepository;
        $this->productRepository = $productRepository;
        $this->postRepository = $postRepository;
    }

    public function getSitemap()
    {
        $urls = [];
        $i = 1;

        /**
         * Меню
         */
        foreach (SiteService::getMenu() as $key1 => $val1) {
            if ($key1 === 'main') {
                /**
                 * Главная
                 */
                foreach ($this->collectionsRepository->getAll() as $collection) {
                    $urls[$i]['url'] = [
                        'loc' => Url::to($collection->getLink(), true),
                        'title' => $collection->title,
                        'type' => 'main',
                        'subtype' => 'main',
                        'lastmod' => date('Y-m-d'),
                        'changefreq' => 'weekly',
                        'priority' => '1',
                    ];
                    $i++;
                }
            } else {
                if (isset(SiteService::getMenu()[$key1]['items'])) {
                    foreach (SiteService::getMenu()[$key1]['items'] as $key2 => $val2) {
                        $urls[$i]['url'] = [
                            'loc' => Url::to($val2['url'], true),
                            'title' => $val2['label'],
                            'type' => $key1,
                            'subtype' => $key2,
                            'lastmod' => date('Y-m-d'),
                            'changefreq' => 'weekly',
                            'priority' => '0.8',
                        ];
                        $i++;
                        if ($key2 === 'store') {
                            /**
                             * Товары
                             */
                            foreach ($this->productRepository->getAll() as $product) {
                                if (ProductSessia::getSessiaForCart($product->id) && $product->coverByCurrencyIso && !empty($product->translateByLangId->title)) {
                                    $urls[$i]['url'] = [
                                        'loc' => Url::to($product->getUrl('sitemap'), true),
                                        'title' => $product->translateByLangId->title,
                                        'type' => $key1,
                                        'subtype' => 'product',
                                        'lastmod' => date("Y-m-d", strtotime($product->updated_at)),
                                        'changefreq' => 'daily',
                                        'priority' => '0.7',
                                    ];
                                    $i++;
                                }
                            }
                        } elseif ($key2 === 'mass-media') {
                            /**
                             * Посты: mass-media
                             */
                            foreach ($this->postRepository->getAll('mass-media') as $key => $post) {
                                $urls[$i]['url'] = [
                                    'loc' => Url::to($post->getUrl(), true),
                                    'title' => $post->title,
                                    'type' => $key1,
                                    'subtype' => 'post',
                                    'lastmod' => date("Y-m-d", strtotime($post->updated_at)),
                                    'changefreq' => 'daily',
                                    'priority' => '0.7',
                                ];
                                $i++;
                            }
                        } elseif ($key2 === 'blog') {
                            /**
                             * Посты: blog
                             */
                            foreach ($this->postRepository->getAll('blog') as $key => $post) {
                                $urls[$i]['url'] = [
                                    'loc' => Url::to($post->getUrl(), true),
                                    'title' => $post->title,
                                    'type' => $key1,
                                    'subtype' => 'post',
                                    'lastmod' => date("Y-m-d", strtotime($post->updated_at)),
                                    'changefreq' => 'daily',
                                    'priority' => '0.7',
                                ];
                                $i++;
                            }
                        }
                    }
                }
            }
        }

        return $urls;
    }

    /**
     * https://www.sitemaps.org/ru/protocol.html
     */
    public function createSiteMap()
    {
        $urls = $this->getSitemap();

        $sitemap = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"></urlset>');
        foreach($urls as $url) {
            $url_tag = $sitemap->addChild("url");
            $url_tag->addChild("loc", $url['url']['loc']);
            $url_tag->addChild("loc", $url['url']['lastmod']);
            $url_tag->addChild("loc", $url['url']['changefreq']);
            $url_tag->addChild("loc", $url['url']['priority']);
        }

        /*header('Content-Type: text/xml');
        echo $sitemap->asXML();
        exit();*/

        $file = 'sitemap.xml';

        $fileDir = Url::to('@webroot/' . $file);
        if (is_file($fileDir)) FileHelper::unlink($fileDir);

        $current = $sitemap->asXML();
        file_put_contents($file, $current);
    }
}
