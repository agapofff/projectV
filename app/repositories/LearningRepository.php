<?php

namespace app\repositories;

use app\entities\about\Learning;

class LearningRepository
{
    public function get($type)
    {
        return new Learning($type);
    }
}
