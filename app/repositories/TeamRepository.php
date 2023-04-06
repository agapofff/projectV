<?php

namespace app\repositories;

use app\entities\about\Team;

class TeamRepository
{
    public function getAll()
    {
        $arr = [];
        foreach (Team::getData() as $key => $val) {
            $arr[$key] = new Team($key);
        }
        return $arr;
    }

    public function get($id)
    {
        return new Team($id);
    }
}
