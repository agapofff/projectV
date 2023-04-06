<?php

namespace app\repositories;

use app\entities\about\LearningItem;

class LearningItemRepository
{
    public function getAllByType($type)
    {
        $arr = [];
        foreach (LearningItem::getData()[$type] as $key => $val) {
            $arr[$key] = new LearningItem($type, $key);
        }
        return $arr;
    }

    public function getCountImgs($type)
    {
        $i = 0;
        foreach (LearningItem::getData()[$type] as $key => $val) {
            $model = new LearningItem($type, $key);
            if (!empty($model->imgs)) {
                $i++;
            }
        }
        return $i;
    }

    public function get($type, $id)
    {
        return new LearningItem($type, $id);
    }
}
