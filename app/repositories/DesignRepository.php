<?php

namespace app\repositories;

use app\entities\main\Design;

class DesignRepository
{
    public function get($key)
    {
        return new Design($key);
    }
}
