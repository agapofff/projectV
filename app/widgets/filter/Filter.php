<?php

namespace app\widgets\filter;

use app\entities\admin\Product;
use yii\bootstrap\Widget;

class Filter extends Widget
{
    public $products;
    public $category;
    public $collection;
    public $sex;
    public $problem;

    public function run()
    {
        $array_url = [
            '/store/default/catalog',
            'category' => $this->category,
            'collection' => $this->collection,
            'sex' => $this->sex,
            'problem' => $this->problem,
        ];

        $categories = $this->getItems($this->products, $array_url, Product::getCategoriesFilter(), 'category');
        $categories_collections = [];
        $categories_filter = Product::getCategoriesFilter();
        foreach ($categories as $category) {
            $cat = $categories_filter[array_search($category['id'], array_column($categories_filter, 'url'))];
            if (!empty($this->category)) {
                $cat['url'] = !stristr($this->category, $cat['url'])
                    ? $this->category . ',' . $cat['url']
                    : $this->category;
            }
            $categories_collections[] = array_merge(
                $category,
                ['items' => $this->getItems($this->products, $array_url, $cat['items'], 'collection', ['category' => $cat['url']])]
            );
        }

        $sex = $this->getItems($this->products, $array_url, Product::getSexFilter(), 'sex');

        $problems = empty($this->category) || stristr($this->category, 'nutraceuticals')
            ? $this->getItems($this->products, $array_url, Product::getProblemsFilter(), 'problem')
            : [];

        return $this->render('@app/widgets/filter/views/_view.php', [
            'categories' => $categories_collections,
            'sex' => $sex,
            'problems' => $problems,
        ]);
    }

    private function getItems(array $products, array $array_url, array $array_filter, string $name, array $suburl = []): array
    {
        $array = $this->getFilterByProducts($products, $array_filter, $name);

        $items = [];

        foreach ($array_filter as $value) {
            $active = in_array($value['url'], explode(',', $array_url[$name]));
            $category = isset($value['items']);
            if ($category) {
                $suburl = ['collection' => ''];
            }
            $items[] = [
                'id' => $value['url'],
                'label' => $value['label'] . (isset($array[$value['url']]) ? '<small>(' . $array[$value['url']]['count'] . ')</small>' : ''),
                'url' => $this->getUrl($array_url, $name, $value['url'], $active, $suburl),
                'template' => isset($array[$value['url']])
                    ? '<a href="{url}" class="catalog-filter__link' . ($category ? '-category' : '') . ' active' . ($active ? ' selected' : '') . '"><span class="catalog-filter__checkbox active' . ($active ? ' selected' : '') . '"></span>{label}</a>'
                    : '<span class="catalog-filter__link' . ($category ? '-category' : '') . ' disable"><span class="catalog-filter__checkbox disable"></span>{label}</span>',
                'options' => [
                    'class' => 'catalog-filter__item' . ($category ? ' category' : ''),
                ],
                'active' => $active,
            ];
        }

        return $items;
    }

    private function getFilterByProducts(array $products, array $array_filter, string $name): array
    {
        $array = [];

        foreach ($products as $product) {
            foreach (explode(',', $product->$name) as $item) {
                $find = array_search($item, array_column($array_filter, 'url'));
                if (is_int($find) && $value = $array_filter[$find]) {
                    $array[$value['url']] = empty($value['url']) ? $value : array_merge($value, ['count' => $this->countNumber($products, $name, $value['url'])]);
                }
            }
        }

        return $array;
    }

    private function countNumber(array $products, string $name, string $value): int
    {
        $count = 0;
        foreach ($products as $item) {
            if (stristr($item->$name, $value)) {
                $count++;
            }
        }

        return $count;
    }

    private function getUrl(array $array_url, string $name, string $value, bool $active, array $suburl = []): array
    {
        $array_url_current = $array_url;

        if (!empty($suburl)) {
            $array_url_current = array_merge($array_url_current, $suburl);
        }

        $current_value = $array_url_current[$name];
        if ($active) {
            $array = explode(',', $current_value);
            foreach ($array as $item) {
                if ($item === $value) {
                    unset($array[array_search($item, $array)]);
                }
            }
            $array_url_current[$name] = implode(',', $array);
        } else {
            $array_url_current[$name] = empty($current_value)
                ? $value
                : $current_value . ',' .  $value;
        }

        return array_filter($array_url_current);
    }
}