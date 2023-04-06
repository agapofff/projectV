<?php

namespace app\repositories;

use app\entities\about\ProductionItem;

class ProductionItemRepository
{
    public function getAll()
    {
        $arr = [];
        foreach (ProductionItem::getData() as $key => $val) {
            $arr[$key] = new ProductionItem($key);
        }
        return $arr;
    }

    public function get($key)
    {
        return new ProductionItem($key);
    }
}
