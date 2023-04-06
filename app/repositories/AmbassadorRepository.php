<?php

namespace app\repositories;

use app\entities\about\Ambassador;

class AmbassadorRepository
{
    public function getAll()
    {
        return Ambassador::find()
            ->orderBy('id')
            ->all();
    }

    public function get(int $id)
    {
        return Ambassador::findOne($id);
    }
}
