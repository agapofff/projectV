<?php

namespace app\repositories;

use app\entities\about\PrivilegeProgram;

class PrivilegeProgramRepository
{
    public function get()
    {
        return new PrivilegeProgram();
    }
}
