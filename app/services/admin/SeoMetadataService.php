<?php

namespace app\services\admin;

use app\entities\admin\SeoMetadata;
use app\repositories\SeoMetadataRepository;
use nirvana\jsonld\JsonLDHelper;
use Yii;
use yii\helpers\Url;

class SeoMetadataService
{
    private $seoMetadataRepository;

    public function __construct(
        SeoMetadataRepository $seoMetadataRepository
    )
    {
        $this->seoMetadataRepository = $seoMetadataRepository;
    }

    public function create()
    {
        $seoRedirect = SeoMetadata::create();
        return $this->seoMetadataRepository->save($seoRedirect);
    }

    public function edit(
        $id,
        $link,
        $title,
        $description,
        $h1,
        $text
    )
    {
        $seoRedirect = $this->seoMetadataRepository->get($id);
        $seoRedirect->edit(
            $link,
            $title,
            $description,
            $h1,
            $text
        );
        $this->seoMetadataRepository->save($seoRedirect);
    }

    public function remove($id): void
    {
        $seoRedirect = $this->seoMetadataRepository->get((int)$id);
        $this->seoMetadataRepository->remove($seoRedirect);
    }

    public function get($params = [])
    {
        $title = '';
        $description = '';
        $h1 = '';
        $text = '';
        $image = isset($params['image']) ? Url::to($params['image'], true) : Url::to('@web/front/img/share.jpg?v=2', true);
        $robots = !(isset($params['robots']) && $params['robots'] === false);

        $link = str_replace("?_pjax=", "", Url::current(['_pjax' => ''], true));

        $seoMetadataRepository = new SeoMetadataRepository();
        $seoMedatada = $seoMetadataRepository->getByLink($link);
        if ($seoMedatada) {
            if (!empty($seoMedatada->title)) {
                $title = $seoMedatada->title;
            }
            if (!empty($seoMedatada->description)) {
                $description = $seoMedatada->description;
            }
            if (!empty($seoMedatada->h1)) {
                $h1 = nl2br($seoMedatada->h1);
            }
            if (!empty($seoMedatada->text)) {
                $text = nl2br($seoMedatada->text);
            }
        } else {
            if (isset($params['title'])) {
                $title = $params['title'];
            }
            if (isset($params['description'])) {
                $description = $params['description'];
            }
            if (isset($params['h1'])) {
                $h1 = $params['h1'];
            }
            if (isset($params['text'])) {
                $text = $params['text'];
            }
        }

        $description = str_replace("<br />", " ", $description);

        $seoMedatada = SeoMetadata::currentPage(
            $title,
            $description,
            $h1,
            $text
        );

        $view = Yii::$app->view;
        $view->title = $seoMedatada->title;
        $view->registerMetaTag(['name' => 'description', 'content' => $seoMedatada->description]);

        if ($robots) {
            $view->registerMetaTag(['name' => 'robots', 'content' => 'index, follow']);
        } else {
            $view->registerMetaTag(['name' => 'robots', 'content' => 'noindex, nofollow']);
        }

        // Open graph
        $view->registerMetaTag(['property' => 'og:url', 'content' => Url::current([], true)], 'og:url');
        $view->registerMetaTag(['property' => 'og:type', 'content' => 'website']);
        $view->registerMetaTag(['property' => 'og:title', 'content' => $title]);
        $view->registerMetaTag(['property' => 'og:description', 'content' => $description]);
        $view->registerMetaTag(['property' => 'og:image', 'content' => $image]);

        $this->getBreadcrumbs($view, $params);
        $this->getProduct($params);
        $this->getOrganization($params);

        $view->registerJs('
        $(document).ready(function() {
            $(document).on("pjax:end", function() {
                $("meta[name=description]").attr("content", "' . $seoMedatada->description . '");
            });
        });
        ');

        return $seoMedatada;
    }

    public function getBreadcrumbs($view, $params = [])
    {
        if (isset($params['breadcrumbs'])) {
            foreach ($params['breadcrumbs'] as $key => $breadcrumbs) {
                $view->params['breadcrumbs'][$key] = [
                    'url' => Url::to($breadcrumbs['url'], true),
                    'label' => strip_tags($breadcrumbs['label']),
                ];
            }
            JsonLDHelper::addBreadcrumbList();
        }
    }

    public function getProduct($params = [])
    {
        if (isset($params['product']) && isset($params['translate']) && isset($params['sessia']) && isset($params['cover'])) {
            $product = $params['product'];
            $translate = $params['translate'];
            $sessia = $params['sessia'];
            $image = $params['image'];
            $context = (object)[
                "@type" => "http://schema.org/Product",
                "http://schema.org/brand" => "project V",
                "http://schema.org/name" => str_replace("&nbsp;", " ", $translate->title),
                "http://schema.org/description" => $translate->description,
                "http://schema.org/image" => Url::to($image, true),
                "http://schema.org/sku" => $sessia->id,
                "http://schema.org/offers" => (object)[
                    "@type" => "http://schema.org/Offer",
                    "http://schema.org/price" => $sessia->price_value,
                    "http://schema.org/priceCurrency" => $sessia->price_iso,
                    "http://schema.org/url" => Url::to($product->getUrl(), true),
                    "http://schema.org/availability" => $sessia->active === 1 ? "http://schema.org/InStock" : "http://schema.org/OutOfStock",
                ],
                "http://schema.org/aggregateRating" => (object)[
                    "@type" => "http://schema.org/AggregateRating",
                    "http://schema.org/ratingValue" => "5",
                    "http://schema.org/reviewCount" => "147",
                ],
            ];
            JsonLDHelper::add($context);
        }
    }

    public function getOrganization($params = [])
    {
        if (isset($params['organization']) && $params['organization']) {
            $model = $params['organization'];
            $context = (object)[
                "@type" => "http://schema.org/Organization",
                "http://schema.org/name" => "project V",
                "http://schema.org/address" => (object)[
                    "@type" => "http://schema.org/PostalAddress",
                    "http://schema.org/addressLocality" => Yii::t('admin', '{city}, {country}', ['city' => $model->city, 'country' => $model->country]),
                    !(empty($model->index)) ? "http://schema.org/postalCode" : '' => !(empty($model->index)) ? $model->index : '',
                    "http://schema.org/streetAddress" => $model->address,
                ],
                "http://schema.org/email" => $model->email,
                "http://schema.org/telephone" => $model->phone,
            ];
            JsonLDHelper::add($context);
        }
    }
}
