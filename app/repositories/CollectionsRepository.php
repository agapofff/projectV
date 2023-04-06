<?php

namespace app\repositories;

use app\entities\main\Collections;

class CollectionsRepository
{
    public function get($key)
    {
        return new Collections($key);
    }

    public function getAll()
    {
        $arr = [];
        foreach (Collections::getData() as $key => $val) {
            $arr[$key] = $this->get($key);
        }
        return $arr;
    }
}
