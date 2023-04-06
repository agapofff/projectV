<?php

namespace app\repositories;

use app\entities\about\CertificateItem;

class CertificateItemRepository
{
    public function getAll()
    {
        $arr = [];
        foreach (CertificateItem::getData() as $key => $val) {
            $arr[$key] = new CertificateItem($key);
        }
        return $arr;
    }

    public function get($key)
    {
        return new CertificateItem($key);
    }
}
