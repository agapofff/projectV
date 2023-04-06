<?php

namespace app\repositories;

use app\entities\about\Tradition;

class TraditionRepository
{
    public function get()
    {
        return new Tradition();
    }
}
