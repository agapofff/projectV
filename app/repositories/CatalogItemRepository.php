<?php

namespace app\repositories;

use app\entities\store\CatalogItem;

class CatalogItemRepository
{
    public function getAllByType($type)
    {
        $arr = [];
        foreach (CatalogItem::getData()[$type] as $key => $val) {
            $arr[$key] = new CatalogItem($type, $key);
        }
        return $arr;
    }

    public function getAllByTypeTest()
    {
        $arr = [];
        $type = 'bio-additives';
        foreach (CatalogItem::getData()[$type] as $key => $val) {
            $arr[$key] = new CatalogItem($type, $key);
        }
        $type = 'for-children';
        foreach (CatalogItem::getData()[$type] as $key => $val) {
            $arr[$key] = new CatalogItem($type, $key);
        }
        $type = 'for-beauty';
        foreach (CatalogItem::getData()[$type] as $key => $val) {
            if ($key === 4)
                $arr[$key] = new CatalogItem($type, $key);
        }
        return $arr;
    }

    public function get($type, $key)
    {
        return new CatalogItem($type, $key);
    }
}
