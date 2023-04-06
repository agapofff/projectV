<?php

namespace app\repositories;

use app\entities\about\TraditionItem;

class TraditionItemRepository
{
    public function getAllByType($type)
    {
        $arr = [];
        foreach (TraditionItem::getData()[$type] as $key => $val) {
            $arr[$key] = new TraditionItem($type, $key);
        }
        return $arr;
    }

    public function getByType($type, $key)
    {
        return new TraditionItem($type, $key);
    }
}
