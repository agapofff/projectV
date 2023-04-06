<?php

namespace app\repositories;

use app\entities\about\Production;

class ProductionRepository
{
    public function get(): object
    {
        return (new Production())->getData();
    }
}
