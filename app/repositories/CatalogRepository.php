<?php

namespace app\repositories;

use app\entities\store\Catalog;

class CatalogRepository
{
    public function get($type)
    {
        return new Catalog($type);
    }
}
