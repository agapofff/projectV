<?php

namespace app\repositories;

use app\entities\about\Mission;

class MissionRepository
{
    public function get()
    {
        return new Mission();
    }
}
