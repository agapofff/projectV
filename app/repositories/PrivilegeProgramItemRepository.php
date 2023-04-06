<?php

namespace app\repositories;

use app\entities\about\PrivilegeProgramItem;

class PrivilegeProgramItemRepository
{
    public function getAll()
    {
        $arr = [];
        foreach (PrivilegeProgramItem::getData() as $key => $val) {
            $arr[$key] = new PrivilegeProgramItem($key);
        }
        return $arr;
    }

    public function getAllByType($type)
    {
        $arr = [];
        foreach (PrivilegeProgramItem::getData() as $key => $val) {
            $model = new PrivilegeProgramItem($type);
            $arr[$key] = $model[$key];
        }
        return $arr;
    }

    public function get($id)
    {
        return new PrivilegeProgramItem($id);
    }
}
