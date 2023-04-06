<?php

namespace app\repositories;

use app\entities\about\Certificate;

class CertificateRepository
{
    public function get()
    {
        return new Certificate();
    }
}
