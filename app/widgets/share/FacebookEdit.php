<?php

namespace app\widgets\share;

use ymaker\social\share\drivers\Facebook;

class FacebookEdit extends Facebook
{
    protected function getMetaTags()
    {
        return [];
    }
}
